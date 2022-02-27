<?php

namespace App\Imports;

use App\Imports\Sheets\PatientHospitalizationImport;
use App\Imports\Sheets\PatientListImport;
use App\Imports\Sheets\PatientMedicationImport;
use App\Imports\Sheets\PatientPastMedImport;
use App\Imports\Sheets\PatientRecordImport;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PatientsImport implements WithMultipleSheets
{
    public function __construct()
    {
        $this->check = [];
    }

    public function sheets(): array
    {
        return [
            'Patients' => new PatientListImport,
            'Records' => new PatientRecordImport,
            'Hospitalizations' => new PatientHospitalizationImport,
            'Past_Medications' => new PatientPastMedImport,
            'Medications' => new PatientMedicationImport,
        ];
    }
}
