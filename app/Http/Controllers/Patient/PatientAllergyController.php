<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use App\Models\Patient\PatientAllergy;
use Illuminate\Http\Request;

class PatientAllergyController extends Controller
{
    public function store (Request $request) {
        $data = $this->validate($request, [
            'patient_id' => 'required|integer',
            'allergy' => 'required|string',
        ]);

        $new_record = PatientAllergy::create($data);

        return response($new_record);
    }
    
    public function update (Request $request, Patient $patient, PatientAllergy $allergy) {
        $data = $this->validate($request, [
            'patient_id' => 'required|integer',
            'allergy' => 'required|string',
        ]);
    
        $allergy->update($data);
    }
}
