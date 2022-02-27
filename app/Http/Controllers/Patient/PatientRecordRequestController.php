<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Patient\Patient;
use App\Patient\PatientRecord;
use App\Patient\PatientRecordRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PatientRecordRequestController extends Controller
{
    //

    public function store (Request $request, Patient $patient, PatientRecord $record) {
        // dd($request->files);
        foreach ($request->files as $key => $value) {
            $imgPath = $request->file("$key")->store('requests', 'public');
            $img = Image::make(public_path("storage/$imgPath"));
            $img->save();

            PatientRecordRequest::create([
                'patient_record_id' => $record->id,
                'request' => $imgPath
            ]);
        }

        return response($record->requests);
    }

    public function delete (Request $request, Patient $patient, PatientRecord $record, PatientRecordRequest $record_request) {
        $old_requests = $record->requests->find($record_request);
        // dd($old_requests);
        $old_requests->delete();
        
        if ($old_requests->request) {
            if (strlen($old_requests->request) > 0) {
                $path = $old_requests->request;
                Storage::disk('public')->delete($path);
            }
        }
    }
}
