<?php

namespace App\Http\Controllers;

use App\Salary;
use App\SalaryHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class SalaryController extends Controller
{
    //
    public function __construct()
    {
        $this->user = new User();
        $this->salary = new Salary();
    }

    public function index (Request $request) 
    {
        // $salaries = $this->salary->get();
        $users = $this->user->lowerUser();
        $salaries = $this->salary;
        if (isset($request->operator) && $request->operator !== 'all') {
            $op = $request->operator;
            $search = $request->search;
            if ($op == "between") {
                $search = explode(",", $search);
                $salaries = $salaries->select('user_id')->whereBetween('monthly', $search)->get();
            }else{
                $salaries = $salaries->select('user_id')->where('monthly', "$op", "$search")->get();
            }
            $users = $users->whereIn('id', $salaries);
        }

        $users = $users->orderBy('lastname')->with('position', 'status', 'salary', 'salaryHistory')->get();
        // dd($users);
        return view('admin.salary.index', compact('users'));
    }

    public function store (Request $request)
    {
        $data = $this->validate($request, [
            'user_id' => 'required|numeric',
            'tndp' => 'required|numeric',
            'salary_type' => [
                'required',
                'string',
                Rule::in(['monthly', 'daily'])
            ],
            'weekly_work_days' => 'required|numeric|min:0|max:7',
            'monthly' => 'required|numeric',
            'increase' => 'nullable|numeric',
            'allowance_type' => [
                'required',
                'string',
                Rule::in(['f&t', 'daily'])
            ],
            'allowance' => 'required|numeric',
        ]);

        $data['half'] = $data['monthly'] / 2;
        $data['daily'] = ($data['monthly'] * 12) / $data['tndp'];
        $data['hourly'] = ($data['daily'] / 24);
        $data['per_min'] = ($data['hourly'] / 60);

        $this->salary->create($data);
    }

    public function update (Request $request, Salary $salary)
    {
        $data = $this->validate($request, [
            'tndp' => 'required|numeric',
            'salary_type' => [
                'required',
                'string',
                Rule::in(['monthly', 'daily'])
            ],
            'weekly_work_days' => 'required|numeric|min:0|max:7',
            'monthly' => 'required|numeric',
            'increase' => 'nullable|numeric',
            'allowance_type' => [
                'required',
                'string',
                Rule::in(['f&t', 'daily'])
            ],
            'allowance' => 'required|numeric',
        ]);

        if ($data['increase'] !== null) {
            $history = [
                'tndp' => $salary->tndp,
                'salary_type' => $salary->salary_type,
                'per_min' => $salary->per_min,
                'hourly' => $salary->hourly,
                'half' => $salary->half,
                'monthly' => $salary->monthly,
                'allowance_type' => $salary->allowance_type,
                'allowance' => $salary->allowance,
                'daily' => $salary->daily,
                'from' => $salary->updated_at,
            ];
    
            $salary->histories()->create($history);

            $data['monthly'] += $data['increase'];
        }

        $data['increase'] = null;
        $data['half'] = $data['monthly'] / 2;
        $data['daily'] = ($data['monthly'] * 12) / $data['tndp'];
        $data['hourly'] = ($data['daily'] / 24);
        $data['per_min'] = ($data['hourly'] / 60);
        
        $salary->update($data);
    }
}
