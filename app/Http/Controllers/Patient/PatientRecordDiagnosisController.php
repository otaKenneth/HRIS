<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Patient\Patient;
use App\Patient\PatientRecord;
use App\Patient\PatientRecordDiagnosis;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PatientRecordDiagnosisController extends Controller
{
    //
    public function store(Request $request, Patient $patient, PatientRecord $record)
    {
        $new_records = [];
        // dd($request->files);
        foreach ($request->files as $key => $value) {
            $imgPath = $request->file("$key")->store('diagnosis', 'public');
            $img = Image::make(public_path("storage/$imgPath"));
            $img->save();

            PatientRecordDiagnosis::create([
                'patient_record_id' => $record->id,
                'diagnosis' => $imgPath
            ]);
        }

        return response($record->diagnoses);
    }

    public function delete (Request $request, Patient $patient, PatientRecord $record, PatientRecordDiagnosis $diagnonsis)
    {
        $old_diagnonsis = $record->diagnoses->find($diagnonsis);
        // dd($old_requests);
        $old_diagnonsis->delete();

        if ($old_diagnonsis->request) {
            if (strlen($old_diagnonsis->request) > 0) {
                $path = $old_diagnonsis->request;
                Storage::disk('public')->delete($path);
            }
        }
    }
}
