<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Events\LeaveRequest;
use App\Notifications\NewRequest;
use App\Models\Request\Leave;
use App\User;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    //
    public function __construct()
    {
        $this->leave = new Leave();
        $this->user = new User();
        $this->check = ['from', 'to', 'leaveRanges.*.date', 'date'];
        $this->options = [
            'all' => ['value' => "All"],
            'on_Going' => ['value' => "On Going"],
            'approved' => ['value' => "Approved"],
            'declined' => ['value' => "Declined"],
            'on_Going_Sick' => ['value' => "On Going Sick"],
            'on_Going_Vacation' => ['value' => "On Going Vacation"],
            'approved_Sick' => ['value' => "Approved Sick Leaves"],
            'declined_Sick' => ['value' => "Declined Sick Leaves"],
            'approved_Vacation' => ['value' => "Approved Vacation Leaves"],
            'declined_Vacation' => ['value' => "Declined Vacation Leaves"]
        ];
    }

    public function index (Request $request)
    {
        $this->authorize('viewAny', auth()->user());
        $options = $this->options;
        $employees = $this->user->userNames();
        $leaves = $this->leave;
        
        if (isset($request->employee)) {
            $emp = $request->employee;
            if ($emp !== "all") {
                foreach ($employees as $key => $value) {
                    if ($value->id == $emp) {
                        $employees[$key]['selected'] = true;
                    }
                }
                $leaves = $leaves->where('user_id', $emp);
            }
        }

        if (isset($request->filter)) {
            $filter = $request->filter;
            $this->options[$filter]['selected'] = true;
            if ($filter !== "all") {
                $leaves = $leaves->$filter();
            }
        }

        if (isset($request->leave)) {
            $leave_id = $request->leave;
            $leaves = $leaves->where('id', $leave_id);
        }
        
        $leaves = $leaves->get();
        $leaves->load('userName', 'leaveRanges');
        $leaves = $this->toMMDDYYYY($leaves, $this->check);
        $leave = json_encode([
            'user_id' => 0, 'from' => null, 'to' => null, 'type' => 'SL', 'reason' => null, 'status' => 0
        ]);
        return view('admin.request.leave', compact('leave', 'leaves', 'request', 'options', 'employees'));
    }

    public function show (Request $request, User $employee)
    {
        $options = $this->options;
        $employees = $this->user->userNames();
        foreach ($employees as $key => $value) {
            if ($value->id == $employee->id) {
                $employees[$key]['selected'] = true;
            }
        }
        $leaves = $this->leave;

        if (isset($request->filter)) {
            $filter = $request->filter;
            $this->options[$filter]['selected'] = true;
            if ($filter !== "all") {
                $leaves = $leaves->$filter();
            }
        }

        if (isset($request->leave)) {
            $leave_id = $request->leave;
            $leaves = $leaves->where('id', $leave_id);
        }

        $leaves = $leaves->where('user_id', $employee->id)->get();
        $leaves->load('userName', 'leaveRanges');
        $leaves = $this->toMMDDYYYY($leaves, $this->check);
        $leave = json_encode([
            'user_id' => $employee->id, 'from' => null, 'to' => null, 'type' => 'SL', 'reason' => null, 'status' => 0, 'disabled' => true
        ]);
        return view('request.leave', compact('leave', 'leaves', 'options', 'employees'));
    }

    public function store(Request $request) {
        $data = $this->validate($request, [
            'leave.user_id' => 'required|numeric',
            'leave.from' => 'required|date|date_format:m/d/Y',
            'leave.to' => 'required|date|date_format:m/d/Y',
            'leave.type' => 'required|string',
            'leave.status' => 'required|numeric',
            'leave.reason' => 'required|string',
            'dateRange.*.date' => 'required|date',
            'dateRange.*.day' => 'required|string',
            'dateRange.*.pay' => 'required|boolean',
        ]);

        $ranges = $request->dateRange;
        $payed = $request->payed;

        $data['leave'] = $this->toDBDate($data['leave']);
        
        $leave = Leave::create($data['leave']);
        $user = $leave->user;

        foreach ($ranges as $range) {
            if (in_array($range['date'], $payed)) $range['pay'] = true ;
            $range = $this->toDBDate($range);
            $shift = $user->schedules()->where('effectivitydate', '<=', $range['date'])->where('day', $range['day'])->latest()->first()->shift()->first();
            if ($shift) {
                if ($shift->code == 'off') {
                    $range['pay'] = 0;
                }
            }
            $leave->leaveRanges()->create($range);
        }
        
        if (!auth()->user()->admin) event(new LeaveRequest($leave, $user, Admin::all())) ;

        return response($leave);
    }

    public function update_status (Request $request, Leave $leave) {
        $data = $this->validate($request, [
            'status' => 'required|numeric',
        ]);
        
        $user = $leave->user;
        if ($leave->status != 1 && $data['status'] == 1) {
            $credit = strtolower($leave->type);
            $dateRange = $leave->leaveRanges();
            $credits = $user["{$credit}_credits"] - $dateRange->usedLeave()->count();
            foreach ($leave->leaveRanges()->get() as $key => $value) {
                $payed = ($value['pay']) ? "paid":"";
                $day = getdate(strtotime($value->date))['wday'];
                $shift = $user->schedules()->where('effectivitydate', '<=', $value->date)->where('day', $day)->latest()->first()->shift()->first();
                if ($shift) {
                    $dtr = [
                        'user_id' => $leave->user_id,
                        'tag' => ($shift->code == 'off') ? $shift->code : trim("$payed $leave->type"),
                        'day' => $day,
                        'leave' => $leave->type,
                        'created_at' => $value->date,
                    ];
                    $existing = $user->dtrs()->where('user_id', $leave->user_id)->where('day', $day)->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') = '{$value->date}'")->first();
                    // dd($existing);
                    if ($existing) {
                        $user->dtrs()->find($existing->id)->update($dtr);
                    }else{
                        $user->dtrs()->create($dtr);
                    }
                }
            }
            $user->update([
                "{$credit}_credits" => $credits
            ]);
        }elseif ($data['status'] == 2){
            if ($leave->status == 1) {
                $credit = strtolower($leave->type);
                $credits = $user["{$credit}_credits"] + $leave->leaveRanges()->usedLeave()->count();
                $user->update([
                    "{$credit}_credits" => $credits
                ]);
            }
        }

        $leave = $leave->find($leave->id);
        $leave->update($data);
        
        event(new LeaveRequest($leave, auth()->user()), [$user]);
        // $redirect_link = "/Leave?leave=$leave->id";
        return redirect()->back();
    }

    public function update (Request $request, Leave $leave) {
        $data = $this->validate($request, [
            'leave.from' => 'required|date|date_format:m/d/Y',
            'leave.to' => 'required|date|date_format:m/d/Y',
            'leave.type' => 'required|string',
            'leave.reason' => 'required|string',
        ]);

        $data['leave'] = $this->toDBDate($data['leave']);
        $leave->update($data['leave']);
        $payed = $request->payed;
        $ranges = $request->dateRange;

        foreach ($ranges as $key => $range) {
            $range['pay'] = (in_array($range['date'], $payed)) ? 1:0;
            $range = $this->toDBDate($range);
            $leave->leaveRanges()->updateOrCreate([
                'leave_id' => $leave->id,
                'date' => $range['date'],
            ], $range);
        }
    }

    public function destroy (Leave $leave)
    {
        $leave->user->notifications()->where('data', 'like', "{\"request_id\":$leave->id,%")->delete();
        foreach (Admin::all() as $admin) {
            $admin->user->notifications()->where('data', 'like', "{\"request_id\":$leave->id,%")->delete();
            $admin->user->notify(new NewRequest([
                'type' => 'deleted'
            ]));
        }
        $leave->leaveRanges()->delete();
        $leave->delete();
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
