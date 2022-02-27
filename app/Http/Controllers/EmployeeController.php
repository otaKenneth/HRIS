<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Lookup;
use App\SuperAdmin;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    
    public function __construct()
    {
        $this->check = ['birthdate', 'hire_date', 'training_start', 'training_evaluation', 'probi_start', 'probi_evaluation', 'reg_start', 'reg_end'];
        $this->lookup = new Lookup();
        $this->user = new User();
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $options = [
            'all' => ['selected' => true, 'value' => "All"],
            'name' => ['value' => "Name"],
            'email' => ['value' => "E-mail"],
            'job_position' => ['value' => "Position"],
            'job_status' => ['value' => "Job Status"],
            'hire_date' => ['value' => "Hiring Date"],
        ];
        $users = [];
        // dd(sizeof($request));
        $users = $this->user->lowerUser();
        if (isset($request['search_key'])) {
            $col_name = $request['search_key'];
            $search = $request['search'];
            if ($col_name !== "all") {
                if ($col_name == "job_position" || $col_name == "job_status") {
                    $lookup = $this->lookup->search($col_name, $search);
                    $users = ($lookup) ? $users->where($col_name, $lookup->id):$users;
                } elseif ($col_name == "name") {
                    $users = $users->whereRaw("concat(firstname, ' ', middlename, ' ', lastname) like '%$search%'");
                } elseif ($col_name == "hire_date") {
                    $date = date('Y-m', strtotime($search));
                    $users = $users->where('hire_date', 'like', "$date%");
                } else {
                    $users = $users->where($col_name, 'like', "%$search%")->get();
                }
            }
            $options[$col_name]['selected'] = true;
        }
        
        if ($users) $users = $users->orderBy('lastname')->get()->load('position', 'status', 'user_level');
        $ids = json_encode(Arr::pluck(Arr::dot($users), 'id'));
        // dd($users);
        return view('admin.employees.masterlist', compact('users', 'options', 'ids'));
    }

    public function create () 
    {
        $this->authorize('create', User::class);
        $user = $this->user->userArrayFillable();
        // dd(gettype($lookups));
        $user['editable'] = false;
        $user = json_encode($user);
        $heads = json_encode([]);

        return view('admin.employees.modifyEmployee', compact('user', 'heads'));
    }

    public function store_basicInfo (Request $request) 
    {
        $this->authorize('create', User::class);
        
        $data = $this->validate($request, [
            'employee_id' => 'required|numeric',
            'userlvl' => 'required|numeric',
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'username' => 'required|string',
            'age' => 'integer',
            'birthdate' => 'required|date',
            'gender' => 'required|integer',
            'cstatus' => 'required|integer',
            'religion' => 'integer',
            'nationality' => 'required|integer'
        ]);

        $data['firstname'] = ucwords($data['firstname']);
        $data['middlename'] = ucwords($data['middlename']);
        $data['lastname'] = ucwords($data['lastname']);
        $data['password'] = Hash::make("default");

        $data = $this->toDBDate($data);

        $user = User::create($data);
        
        $this->checkAdmin($user);

        return response($user);
    }

    public function edit(User $employee)
    {
        $this->authorize('update', auth()->user());
        $user = $employee;
        $employee->addresses;
        $employee->user_level;
        
        $user = $this->toMMDDYYYY([$user], $this->check)[0];
        // dd($user);
        $user['editable'] = true;

        $heads = User::select('id', 'firstname', 'middlename', 'lastname')
            ->where('job_position', '>', $user['job_position'] + 6)
            ->where('job_position', '<', $user['job_position'])
            ->get();

        return view('admin.employees.modifyEmployee', compact('user', 'heads'));
    }

    public function update_basicInfo(Request $request, User $employee)
    {
        $this->authorize('update', auth()->user());
        $data = $this->validate($request, [
            'employee_id' => 'required|numeric',
            'userlvl' => 'required|numeric',
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'username' => 'required|string',
            'age' => 'integer',
            'birthdate' => 'required|date',
            'gender' => 'required|integer',
            'cstatus' => 'required|integer',
            'religion' => 'integer',
            'nationality' => 'required|integer',
        ]);

        $data['firstname'] = ucwords($data['firstname']);
        $data['middlename'] = ucwords($data['middlename']);
        $data['lastname'] = ucwords($data['lastname']);
        $data = $this->toDBDate($data);

        $employee->update($data);
        
        $this->checkAdmin($employee);

        return response($employee);
    }

    private function checkAdmin ($user) {
        if (Lookup::find($user['userlvl'])->index == 1) {
            SuperAdmin::updateOrCreate([
                'user_id' => $user['id']
            ], [
                'user_id' => $user['id']
            ]);
        } else {
            SuperAdmin::where('user_id', $user['id'])->delete();
        }

        if (Lookup::find($user['userlvl'])->index == 2) {
            Admin::updateOrCreate([
                'user_id' => $user['id']
            ], [
                'user_id' => $user['id']
            ]);
            SuperAdmin::where('user_id', $user['id'])->delete();
        } else {
            Admin::where('user_id', $user['id'])->delete();
        }
    }

    public function update_profile (Request $request, User $employee) 
    {
        $this->authorize('update', auth()->user());
        $data = $this->validate($request, [
            'profile' => ''
        ]);

        // dd($request->profile);
        if ($request->profile) {
            $old_porfile = $employee->profile;
            if (strlen($old_porfile) > 0) {
                Storage::disk('public')->delete($old_porfile);
            }

            $imgPath = $request->file('profile')->store('uploads', 'public');
            $img = Image::make(public_path("storage/$imgPath"))->fit(200, 200);
            $img->stream('jpg', 0);
            $img->save();
            // $request->file('profile')->move(public_path("/storage/uploads"), $imgPath);
        }

        $new_record = User::where('id', $employee->id)->update([
            'profile' => $imgPath
        ]);
        
        return response($new_record);
    }

    public function update_contactInfo(Request $request, $employee)
    {
        $this->authorize('update', auth()->user());
        $data = $this->validate($request, [
            'email' => 'required|string|email',
            'mnum' => 'required|string',
            'tnum' => 'string|nullable'
        ]);

        User::where('id', $employee)->update($data);
    }

    public function update_jobInfo(Request $request, $employee)
    {
        $this->authorize('update', User::class);
        $data = $this->validate($request, [
            'tax' => 'required|boolean',
            'sss' => 'required|boolean',
            'philhealth' => 'required|boolean',
            'pagibig' => 'required|boolean',
            // 'location' => 'required|integer',
            // 'department' => 'required|integer',
            'job_position' => 'required|integer',
            // 'proj_team' => 'integer',
            // 'head' => 'integer',
            // 'corp_rank' => 'required|integer',
            'job_status' => 'required|integer',
            // 'job_grd' => 'integer',
        ]);

        User::where('id', $employee)->update($data);
    }

    public function update_empStat(Request $request, $employee)
    {
        $this->authorize('update', auth()->user());
        $data = $this->validate($request, [
            'emp_status' => 'required|integer',
            'hire_date' => 'required|date',
            'training_start' => 'required|date',
            'training_evaluation' => 'nullable|date',
            'probi_start' => 'nullable|date',
            'probi_evaluation' => 'nullable|date',
            'reg_start' => 'nullable|date',
            'reg_end' => 'nullable|date',
            'sl_credits' => 'integer',
            'vl_credits' => 'integer',
            'rol' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $data = $this->toDBDate($data);

        User::where('id', $employee)->update($data);
    }

    public function getEmployeeNames ()
    {
        $user = new User;
        return response($user->userNames());
    }

    public function getLeaveCredits (User $employee)
    {
        return response($employee->leaveCredits());
    }

    public function export (String $ids)
    {
        $ids = json_decode($ids);
        return Excel::download(new UsersExport($ids), 'employee.xlsx');
    }

    public function import (Request $request)
    {
        // dd($request->file('file'));
        Excel::import(new UsersImport, $request->file('file'));
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
