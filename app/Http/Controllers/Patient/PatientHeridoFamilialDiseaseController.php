<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use App\Models\Patient\PatientHeridoFamilialDisease;
use Illuminate\Http\Request;

class PatientHeridoFamilialDiseaseController extends Controller
{
    //
    public function store (Request $request) {
        $data = $this->validate($request, [
            'patient_id' => 'required|numeric',
            'disease' => 'required|string'
        ]);

        $new_record = PatientHeridoFamilialDisease::create($data);

        return response($new_record);
    }
    
    public function update (Request $request, Patient $patient, PatientHeridoFamilialDisease $desease) {
        $data = $this->validate($request, [
            'patient_id' => 'required|numeric',
            'disease' => 'required|string'
        ]);
    
        $desease->update($data);
    }
}
