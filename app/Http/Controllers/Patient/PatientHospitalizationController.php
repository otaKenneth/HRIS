<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use App\Models\Patient\PatientHospitalization;
use App\Models\Patient\PatientRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientHospitalizationController extends Controller
{
    //
    private $check = ['h_date'];

    public function store (Request $request, Patient $patient, PatientRecord $record) {
        $data = $this->validate($request, [
            'hospital' => 'required|string|max:255',
            'h_date' => 'required|date|date_format:m/d/Y',
            'dx' => 'required|string',
            'duration' => 'required|string',
            'attending' => 'required|string',
            'remarks' => 'required|string|max:255',
        ]);

        $data['hospital'] = Str::title($data['hospital']);
        $data['attending'] = Str::title($data['attending']);
        $data = $this->toDBDate($data);

        $new_record = $record->hospitalizations()->create($data);
        
        $new_record = $this->toMMDDYYYY([$new_record], $this->check)[0];
        return response($new_record);
    }

    public function update (Request $request, Patient $patient, PatientRecord $record, PatientHospitalization $hospitalization) {
        
        $data = $this->validate($request, [
            'hospital' => 'required|string|max:255',
            'h_date' => 'required|date|date_format:m/d/Y',
            'dx' => 'required|string',
            'duration' => 'required|string',
            'attending' => 'required|string',
            'remarks' => 'required|string|max:255',
        ]);

        $data['hospital'] = Str::title($data['hospital']);
        $data['attending'] = Str::title($data['attending']);
        $data = $this->toDBDate($data);

        $record->hospitalizations()->update($data);
    }

    private function toMMDDYYYY($arr, $needles, $opt = null)
    {
        foreach ($arr as $key => $value) {
            foreach ($needles as $index => $needle) {
                if (strpos($needle, '.') > -1) {
                    $temp = explode('.', $needle);
                    $this->toMMDDYYYY($value[$temp[0]], [$temp[2]]);
                } else {
                    $arr[$key][$needle] = ($value[$needle] == null || $value[$needle] == "" || $value[$needle] == "0000-00-00") ? null : date('m/d/Y', strtotime($value[$needle]));
                }
            }
        }

        return $arr;
    }

    private function toDBDate($arr)
    {
        foreach ($this->check as $key) {
            if ($arr[$key] == null || $arr[$key] == "" || $arr[$key] == "0000-00-00") {
                $arr[$key] = null;
            } else {
                $arr[$key] = date('Y-m-d', strtotime($arr[$key]));
            }
        }

        return $arr;
    }
}
