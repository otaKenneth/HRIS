<?php

namespace App\Http\Controllers\Patient;

use App\Exports\PatientsExport;
use App\Http\Controllers\Controller;
use App\Imports\PatientsImport;
use App\Patient\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->check = ['birthdate'];
        $this->patient = new Patient;
    }

    public function index (Request $request) 
    {
        $this->authorize('viewAny', auth()->user());
        $patients = $this->patient;
        $searches = $this->patient->patientNames();
        if ($request->search) {
            $search = $request->search;
            $patients = $patients->where('id', $search);
        }
        $patients = $patients->get()->fresh('gen');
        $ids = json_encode(Arr::pluck(Arr::dot($patients), 'id'));
        // dd($patients[0]['gen']);
        return view('admin.patients.patients', compact('patients', 'searches', 'ids'));
    }

    public function create()
    {
        $patient = [
            'firstname' => null,
            'middlename' => null,
            'lastname' => null,
            'age' => null,
            'birthdate' => null,
            'gender' => null,
            'email' => null,
            'pnum' => null,
            'address' => null,
            'town' => "MM",
            'province' => 0,
            'country' => "Philippines"
        ];
        return view('admin.patients.create', compact('patient'));
    }

    public function store (Request $request) 
    {
        $data = $this->validate($request, [
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'age' => 'required|integer',
            'birthdate' => 'required|date|date_format:m/d/Y',
            'gender' => 'required|integer',
            'email' => 'nullable|email',
            'pnum' => 'required|numeric|string',
            'address' => 'required|string',
            'town' => 'required|integer',
            'province' => 'required|integer',
            'country' => 'required|string',
        ]);
        
        $data['firstname'] = Str::title($data['firstname']);
        $data['middlename'] = Str::title($data['middlename']);
        $data['lastname'] = Str::title($data['lastname']);
        $data['address'] = Str::title($data['address']);
        $data = $this->toDBDate($data);
        // dd($data);
        $patient = Patient::firstOrCreate(
            [
                'firstname' => $data['firstname'],
                'middlename' => $data['middlename'],
                'lastname' => $data['lastname'],
                'birthdate' => $data['birthdate'],
            ],
            $data
        );
        
        return redirect()->to("/Patient/$patient->id/Edit");
        // return response($patient);
    }

    public function createFromDashboard (Request $request)
    {
        $data = $this->validate($request, [
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'age' => 'required|integer',
            'birthdate' => 'required|date|date_format:m/d/Y',
            'gender' => 'required|integer',
            'email' => 'nullable|email',
            'pnum' => 'required|numeric|string',
            'address' => 'required|string',
            'town' => 'required|integer',
            'province' => 'required|integer',
            'country' => 'required|string',
        ]);

        $data['firstname'] = Str::title($data['firstname']);
        $data['middlename'] = Str::title($data['middlename']);
        $data['lastname'] = Str::title($data['lastname']);
        $data['address'] = Str::title($data['address']);
        $data = $this->toDBDate($data);
        // dd($data);
        $patient = Patient::firstOrCreate(
            [
                'firstname' => $data['firstname'],
                'middlename' => $data['middlename'],
                'lastname' => $data['lastname'],
                'birthdate' => $data['birthdate'],
            ],
            $data
        );

        return response($patient);
    }

    public function edit (Patient $patient) 
    {
        $this->authorize('update', auth()->user());
        $records = $patient->records;
        $p = $patient->fresh('gen', 'allergies', 'hfds');
        
        $p = $this->toMMDDYYYY([$p], $this->check)[0];

        $patient = $p;
        // dd($records);
        return view('admin.patients.records', compact('patient','records'));
    }
    
    public function update (Request $request, Patient $patient) 
    {
        $data = $this->validate($request, [
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'age' => 'required|integer',
            'birthdate' => 'required|date|date_format:m/d/Y',
            'gender' => 'required|integer',
            'email' => [
                'required',
                'email',
                Rule::unique('patients')->ignore($patient),
            ],
            'pnum' => 'required|string',
            'address' => 'required|string',
            'town' => 'required|integer',
            'province' => 'required|integer',
        ]);

        $data['firstname'] = Str::title($data['firstname']);
        $data['middlename'] = Str::title($data['middlename']);
        $data['lastname'] = Str::title($data['lastname']);
        $data['address'] = Str::title($data['address']);
        $data = $this->toDBDate($data);

        $patient->update($data);

        return redirect()->back();
    }

    public function export (String $ids)
    {
        $ids = json_decode($ids);
        return Excel::download(new PatientsExport($ids), 'patients.xlsx');
    }

    public function import (Request $request)
    {
        // dd($request->file('file'));
        Excel::import(new PatientsImport, $request->file('file'));
        // dd("");
        return redirect()->back();
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
