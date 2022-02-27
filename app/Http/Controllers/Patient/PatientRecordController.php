<?php

namespace App\Http\Controllers\Patient;

use App\Events\PatientToday;
use App\Http\Controllers\Controller;
use App\Patient\Patient;
use App\Patient\PatientRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class PatientRecordController extends Controller
{
    private $check = ['next_visit', 'hospitalizations.*.h_date'];
    
    public function create (Patient $patient)
    {
        $record = PatientRecord::find(1)->load('examination', 'medications', 'past_medications', 'requests', 'diagnoses', 'hospitalizations')->toArray();
        foreach ($record as $key => $value) {
            $record[$key] = (is_array($value)) ? []:null;
        }
        $record['patient_id'] = $patient->id;
        $record = json_encode($record);
        $editable = false;
        return view('admin.patients.record.edit', compact('patient', 'record', 'editable'));
    }

    public function edit (Patient $patient, PatientRecord $record)
    {
        $this->authorize('update', auth()->user());
        $record->load('examination', 'medications', 'past_medications', 'requests', 'diagnoses', 'hospitalizations');
        $record = $this->toMMDDYYYY([$record], $this->check)[0];
        $patient->load('allergies', 'hfds');
        $editable = true;
        return view('admin.patients.record.edit', compact('patient','record','editable'));
        // return response($record);
    }

    public function getPatientsAtDate () {
        $date = date('Y-m-d');
        $records = PatientRecord::select('patient_id', 'payment', 'payed', 'created_at')->where('created_at', 'like', "$date%")->latest()->get();

        foreach ($records as $key => $record) {
            $record->patient;
        }

        return response($records);
    }

    public function store (Request $request, Patient $patient, $tab) 
    {
        $data = $this->validate($request, [
            'patient_id' => 'required|numeric',
            'gen_survey' => 'required|string|max:255',
            'bp' => 'required|string',
            'hr' => 'required|string',
            'rr' => 'required|string',
            'weight' => 'required|integer',
            'temp' => 'nullable|integer',
            'chief_complaint' => 'required|string|max:255',
        ]);

        $record = PatientRecord::create($data);
        return response($record);
    }

    public function storeFromDashboard(Request $request, Patient $patient)
    {
        $data = $this->validate($request, [
            'patient_id' => 'required|numeric',
            'weight' => 'required|integer',
        ]);

        event(new PatientToday('hi'));

        PatientRecord::create($data);
    }

    public function update (Request $request, Patient $patient, PatientRecord $record, $tab) 
    {
        $this->authorize('update', auth()->user());

        $data = $this->$tab($request, $record);

        $record->update($data);
        $record->load('examination', 'medications', 'past_medications', 'requests', 'diagnoses', 'hospitalizations');
        $record = $this->toMMDDYYYY([$record], $this->check)[0];

        return response($record);
    }

    private function generalsurvey ($request, $record) {
        // dd($request);
        $data = $this->validate($request, [
            'gen_survey' => 'required|string|max:255',
            'bp' => 'required|string',
            'hr' => 'required|string',
            'rr' => 'required|string',
            'weight' => 'required|integer',
            'temp' => 'nullable|integer',
            'chief_complaint' => 'required|string|max:255',
        ]);

        return $data;
    }

    private function hpi ($request, $record) {
        $data = $this->validate($request, [
            'site' => 'nullable|string|max:255',
            'onset' => 'nullable|string|max:255',
            'character' => 'nullable|string|max:255',
            'radiation' => 'nullable|string|max:255',
            'association' => 'nullable|string|max:255',
            'time' => 'nullable|string|max:255',
            'exacerbating' => 'nullable|string|max:255',
            'severity' => 'nullable|string|max:255',
            'plt' => 'nullable|string|max:255',
        ]);

        return $data;
    }

    private function pmh ($request, $record) {
        // return response(true);
    }

    private function ppe ($request, $record) {
        $data = $this->validate($request, [
            'examination.skin' => 'nullable|string',
            'examination.hair' => 'nullable|string',
            'examination.nails' => 'nullable|string',
            'examination.head' => 'nullable|string',
            'examination.eyes' => 'nullable|string',
            'examination.ears' => 'nullable|string',
            'examination.nose' => 'nullable|string',
            'examination.mouth' => 'nullable|string',
            'examination.abdomen' => 'nullable|string',
            'examination.heart' => 'nullable|string',
            'examination.back' => 'nullable|string',
            'examination.throat' => 'nullable|string',
            'examination.neck' => 'nullable|string',
            'examination.cl' => 'nullable|string',
            'examination.ext' => 'nullable|string',
            'examination.impression' => 'nullable|string',
        ]);

        $data['examination']['patient_record_id'] = $record->id;
        $record->examination()->updateOrCreate(
            ['patient_record_id' => $record->id],
            $data['examination']
        );

        return [];
    }

    private function rnd ($request, $record) {
        // return response(true);
    }

    private function medication ($request, $record) {
        $data = $this->validate($request, [
            'payment' => 'nullable|numeric',
            'next_visit' => 'nullable|date',
            'note' => 'nullable|string|max:500',
        ]);

        event(new PatientToday($data));
        
        $data = $this->toDBDate($data);

        return $data;
    }

    private function toMMDDYYYY ($arr, $needles, $opt = null) {
        foreach ($arr as $key => $value) {
            foreach ($needles as $index => $needle) {
                if (strpos($needle, '.') > -1) {
                    $temp = explode('.', $needle);
                    $this->toMMDDYYYY($value[$temp[0]], [$temp[2]]);
                }else{
                    $arr[$key][$needle] = ($value[$needle] == null || $value[$needle] == "" || $value[$needle] == "0000-00-00") ? null:date('m/d/Y', strtotime($value[$needle]));
                }
            }
        }

        return $arr;
    }

    private function toDBDate ($arr) {
        foreach ($this->check as $key) {
            if (array_key_exists($key, $arr)) {
                if ($arr[$key] == null || $arr[$key] == "" || $arr[$key] == "0000-00-00") {
                    $arr[$key] = null;
                } else {
                    $arr[$key] = date('Y-m-d', strtotime($arr[$key]));
                }
            }
        }

        return $arr;
    }
}
