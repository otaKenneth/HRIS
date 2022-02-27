<?php

namespace App\Http\Controllers;

use App\Rules\Password;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //

    public function __construct()
    {
        $this->check = ['birthdate', 'hire_date', 'training_start', 'training_evaluation', 'probi_start', 'probi_evaluation', 'reg_start', 'reg_end'];
        $this->today = date('Y-m-d');
        $this->user = new User();
    }

    public function index (User $employee)
    {
        $this->authorize('view', $employee);
        $heads = User::select('id', 'firstname', 'middlename', 'lastname')
            ->where('job_position', '>', $employee->job_position + 6)
            ->where('job_position', '<', $employee->job_position)
            ->get();

        $user = $employee;
        $user['disabled'] = true;
        $salary = $employee->salary;
        $schedule = $employee->latestSchedule;
        $events = [];
        foreach ($schedule as $key => $value) {
            $shift = $value->shift;
            
            $day = $value->day;
            $date = $this->today;
            $dayofweek = date('w', strtotime($date));
            $result    = date('Y-m-d', strtotime(($day - $dayofweek) . ' day', strtotime($date)));
            $leave     = $user->leaves()->where('from', '<=', $result)->where('to', '>=', $result)->first();
            
            if (!in_array($shift->code,["off","flexitime"])) {
                if ($leave) {
                    $events[] = [
                        'name' => "$leave->type",
                        'start' => "$result 01:00",
                        'end' => "$result 00:00",
                    ];
                }else{
                    $events[] = [
                        'name' => "Schedule",
                        'start' => "$result $shift->in",
                        'end' => "$result $shift->out",
                    ];
                }
            }
        }
        // dd($events);
        $user = $this->toMMDDYYYY([$user], $this->check)[0];
        // dd($user);
        return view('profile', compact('user', 'heads', 'salary', 'events'));
    }

    public function update_password (Request $request, User $employee)
    {
        $this->authorize('view', $employee);
        // dd($request);
        $data = $this->validate($request, [
            'old_password' => ['required', 'string', new Password],
            'password' => 'required|string|min:8|confirmed'
        ]);

        $employee->update([
            'password' => Hash::make($data['password']),
        ]);

        Auth::logout();

        return redirect('/login');
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
}
