<?php

namespace App\Imports\Sheets;

use App\Patient\PatientHospitalization;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PatientHospitalizationImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            $value = $row->toArray();
            $value['h_date'] = $value['hospitalization_date'];
            Arr::forget($value, 'hospitalization_date');

            $record = PatientHospitalization::find($value['id']);
            // dump($record);
            if ($record) {
                $record->update($value);
            }else{
                PatientHospitalization::create($value);
            }
        }
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
