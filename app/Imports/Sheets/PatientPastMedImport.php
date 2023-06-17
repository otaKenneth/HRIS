<?php

namespace App\Imports\Sheets;

use App\Models\Patient\PatientPastMedication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PatientPastMedImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            $value = $row->toArray();
            $record = PatientPastMedication::find($value['id']);
            // dump($record);
            if ($record) {
                $record->update($value);
            }else{
                PatientPastMedication::create($value);
            }
        }
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
