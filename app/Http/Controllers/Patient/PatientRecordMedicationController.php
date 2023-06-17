<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use App\Models\Patient\PatientRecord;
use App\Models\Patient\PatientRecordMedication;
use Illuminate\Http\Request;

class PatientRecordMedicationController extends Controller
{
    //
    public function store (Request $request) {
        $data = $this->validate($request, [
            'patient_record_id' => 'required|numeric',
            'name' => 'required|string',
            'dose' => 'required|string',
            'duration' => 'required|string',
            'frequency' => 'required|string', 
            'remarks' => 'required|string'
        ]);
        
        $new_record = PatientRecordMedication::create($data);
        
        return response($new_record);
    }
    
    public function update (Request $request, Patient $patient, PatientRecord $record, PatientRecordMedication $medication) {
        $data = $this->validate($request, [
            'patient_record_id' => 'required|numeric',
            'name' => 'required|string',
            'dose' => 'required|string',
            'duration' => 'required|string',
            'frequency' => 'required|string',
            'remarks' => 'required|string'
        ]);

        $new_record = $record->medications()->update($data);

        return response($new_record);
    }
}
