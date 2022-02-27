<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Patient\Patient;
use App\Patient\PatientPastMedication;
use App\Patient\PatientRecord;
use Illuminate\Http\Request;
use illuminate\Support\Str;

class PatientPastMedicationController extends Controller
{   
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'patient_record_id' => 'required|integer',
            'name' => 'required|string',
            'dose' => 'required|string',
            'frequency' => 'required|string',
            'duration' => 'required|string',
            'remarks' => 'required|string',
        ]);

        $data['name'] = Str::title($data['name']);

        $new_record = PatientPastMedication::create($data);

        return response($new_record);
    }

    public function update(Request $request, Patient $patient, PatientRecord $record, PatientPastMedication $pastmed)
    {
        $data = $this->validate($request, [
            'patient_record_id' => 'required|integer',
            'name' => 'required|string',
            'dose' => 'required|string',
            'frequency' => 'required|string',
            'duration' => 'required|string',
            'remarks' => 'required|string',
        ]);

        $data['name'] = Str::title($data['name']);

        $record->past_medications()->update($data);
    }
}
