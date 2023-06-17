<?php

namespace App\Exports\Sheets;

use App\Models\Patient\Patient;
use App\Models\Patient\PatientRecord;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class PatientsSheets implements FromArray, WithTitle
{
    private $myTitle;
    private $ids;

    public function __construct(Array $ids, String $sheetTitle)
    {
        $this->ids = $ids;
        $this->myTitle = $sheetTitle;
    }
    
    public function array(): array
    {
        $fxn = $this->myTitle;
        return $this->$fxn();
    }

    public function title(): string
    {
        return Str::title($this->myTitle);
    }

    private function patients()
    {
        $patients = Patient::find($this->ids)->load("gen")->toArray();
        $exportable = [];
        // dd($patients);
        [$exportable[0], $temp] = Arr::divide($patients[0]);
        Arr::forget($exportable[0], [11, 12, 16]);
        foreach ($patients as $key => $patient) {
            $value = $patient;
            $value['gender'] = $value['gen']['value'];
            Arr::forget($value, 'town');
            Arr::forget($value, 'province');
            Arr::forget($value, 'gen');
            $exportable[] = $value;
        }
        return $exportable;
    }

    private function records()
    {
        $patients = PatientRecord::whereIn("patient_id", $this->ids)->orderBy("patient_id")->get()->toArray();
        $exportable = [];
        // dd($patients);
        [$exportable[0], $temp] = Arr::divide($patients[0]);
        // Arr::forget($exportable[0], [11, 12, 16]);
        foreach ($patients as $key => $patient) {
            $value = $patient;
            // $value['gender'] = $value['gen']['value'];
            // Arr::forget($value, 'town');
            // Arr::forget($value, 'province');
            // Arr::forget($value, 'gen');
            $exportable[] = $value;
        }
        return $exportable;
    }

    private function hospitalizations()
    {
        $patients = PatientRecord::whereIn("patient_id", $this->ids)->orderBy("patient_id")->get()->load("hospitalizations");
        $exportable = [];
        foreach ($patients as $key => $patient) {
            $value = $patient->hospitalizations->toArray();
            if ($key == 0) $exportable[0] = array_keys($value[0]);
            $exportable = array_merge($exportable, $value);
        }
        $exportable[0][3] = "hospitalization date";
        // dd($exportable);
        return $exportable;
    }
    
    private function medications()
    {
        $patients = PatientRecord::whereIn("patient_id", $this->ids)->orderBy("patient_id")->get()->load("medications");
        $exportable = [];
        foreach ($patients as $key => $patient) {
            $value = $patient->medications->toArray();
            if ($key == 0) $exportable[0] = array_keys($value[0]);
            $exportable = array_merge($exportable, $value);
        }
        // dd($exportable);
        return $exportable;
    }
    
    private function past_medications()
    {
        $patients = PatientRecord::whereIn("patient_id", $this->ids)->orderBy("patient_id")->get()->load("past_medications");
        $exportable = [];
        foreach ($patients as $key => $patient) {
            $value = $patient->past_medications->toArray();
            if ($key == 0) $exportable[0] = array_keys($value[0]);
            $exportable = array_merge($exportable, $value);
        }
        // dd($exportable);
        return $exportable;
    }
}
