<?php

namespace App\Imports\Sheets;

use App\Models\Lookup;
use App\Models\Patient\Patient;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PatientListImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            $value = $row->toArray();
            
            $gender = $this->createLookup('Gender', 'gender', $value['gender']);
            $value['gender'] = Lookup::select('id')->firstOrCreate($gender, $gender)->id;
            
            $patient = Patient::find($value['id']);
            // dump($patient);
            if ($patient) {
                $patient->update($value);
            }else{
                Patient::create($value);
            }
        }
    }

    public function chunkSize(): int
    {
        return 10;
    }

    private function createLookup($label, $key, $value)
    {
        return [
            'label' => $label,
            'key' => $key,
            'value' => $value
        ];
    }
}
