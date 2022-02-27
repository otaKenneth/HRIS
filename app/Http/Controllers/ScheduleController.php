<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ScheduleController extends Controller
{
    //
    public function __construct()
    {
        $this->user = new User();
        $this->check = ['schedules.*.effectivitydate', 'latestSchedule.*.effectivitydate'];
    }

    public function index () {
        $users = [];

        $users = $this->user->lowerUser()->select(DB::raw("*, DATE_FORMAT(hire_date, '%b %d, %Y') as hire_date"))->orderBy('lastname')->with('position', 'status', 'user_level')->get();
        
        $users = $this->toMMDDYYYY($users, $this->check);
        
        return view('admin.schedule.index', compact('users'));
    }

    public function getUserSchedule (User $user) {
        $scheds = $user->schedules;
        $new_scheds = [];

        $days = ['sun','mon','tue','wed','th','fri','sat'];
        
        foreach ($scheds as $key => $sched) {
            $date = date('m/d/Y', strtotime($sched['effectivitydate']));
            if (!array_key_exists($date, $new_scheds)) {
                $new_scheds[$date] = ['user_id' => $sched['user_id'], 'effectivitydate' => $date];
            }
            $day = $days[$sched['day']];
            $new_scheds[$date]["{$day}_id"] = $sched['id'];
            $new_scheds[$date][$day] = $sched['shift_id'];
        }

        $response = Arr::divide($new_scheds);

        return response($response);
    }

    public function store (Request $request) {
        // dd(getdate());
        $schedule = $request->schedule;

        $this->validate($request, [
            'schedule.effectivitydate' => 'required|date|date_format:m/d/Y',
            'schedule.sun' => 'required|numeric',
            'schedule.mon' => 'required|numeric',
            'schedule.tue' => 'required|numeric',
            'schedule.wed' => 'required|numeric',
            'schedule.th' => 'required|numeric',
            'schedule.fri' => 'required|numeric',
            'schedule.sat' => 'required|numeric',
        ]);
        
        $date = date('Y-m-d', strtotime($schedule['effectivitydate']));
        $days = ['sun', 'mon', 'tue', 'wed', 'th', 'fri', 'sat'];

        foreach ($request->selecteds as $key => $emp) {
            foreach ($days as $key => $day) {
                $sched = [
                    'user_id' => $emp,
                    'shift_id' => $schedule["$day"],
                    'effectivitydate' => $date,
                    'day' => $key,
                ];
                
                Schedule::create($sched);
            }
        }
    }

    public function update (Request $request, User $user) {
        $res = [];
        $schedule = $this->validate($request, [
            'effectivitydate' => 'required|date|date_format:m/d/Y',
            'sun' => 'required|numeric',
            'mon' => 'required|numeric',
            'tue' => 'required|numeric',
            'wed' => 'required|numeric',
            'th' => 'required|numeric',
            'fri' => 'required|numeric',
            'sat' => 'required|numeric',
        ]);

        $date = date('Y-m-d', strtotime($schedule['effectivitydate']));
        $days = ['sun', 'mon', 'tue', 'wed', 'th', 'fri', 'sat'];
        foreach ($days as $key => $day) {
            $sched = [
                'shift_id' => $schedule[$day],
                'effectivitydate' => $date,
                'day' => $key,
            ];

            $sched_id = $request["{$day}_id"];
            $oldSched = $user->schedules()->find($sched_id);
            $res['effectivitydate'] = ($oldSched->effectivitydate == $sched['effectivitydate']) ? false: true;
            $res['day'][$key] = ($oldSched->shift_id == $sched['shift_id']) ? false: true;
            $oldSched->update($sched);
        }

        return response($res);
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

    // private function schedule_chunk ($arr) 
    // {
    //     foreach ($arr as $key => $user) {
    //         $scheds = (array) $user['schedules'];
    //         $schedule = array_chunk($scheds["\x00*\x00items"], 7);
    //         // dd($schedule);
    //         $arr[$key]['schedules'] = $schedule;
    //     }

    //     return $arr;
    // }
}
