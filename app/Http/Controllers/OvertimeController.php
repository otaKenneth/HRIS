<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Notifications\NewRequest;
use App\Request\Overtime;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\DailyTimeRecordController;

class OvertimeController extends Controller
{
    public function __construct()
    {
        $this->user = new User();
        $this->overtime = new Overtime();
        $this->DTR = new DailyTimeRecordController();
        $this->check = ['date'];
        $this->options = [
            'all' => ['selectd' => true, 'value' => 'All'],
            'on_Going' => ['value' => "On Going"],
            'approved' => ['value' => "Approved"],
            'declined' => ['value' => "Declined"],
        ];
        $this->ot_inputs = [
            'user_id' => 0,
            'date' => null,
            'in' => null,
            'out' => null,
            'status' => 0,
            'reason' => null,
            'disabled' => false,
        ];
    }

    public function index (Request $request)
    {
        $this->authorize('viewAny', auth()->user());
        $options = $this->options;
        $overtimes = $this->overtime;
        $employees = $this->user->userNames();
        if (isset($request->filter)) {
            $filter = $request->filter;
            $overtimes = $overtimes->$filter();
            $options[$filter]['selected'] = true;
        }

        if (isset($request->employee)) {
            $emp = $request->employee;
            foreach ($employees as $key => $value) {
                if ($value->id == $emp) {
                    $employees[$key]['selected'] = true;
                }
            }
            $overtimes = $overtimes->where('user_id', $emp);
        }

        if (isset($request->overtime)) {
            $ot_id = $request->overtime;
            $overtimes = $overtimes->where('id', $ot_id);
        }

        $overtimes = $overtimes->with('user')->get();
        $overtime = json_encode($this->ot_inputs);
        return view('admin.request.overtime', compact('options', 'employees', 'overtimes', 'overtime'));
    }

    public function show (Request $request, User $employee)
    {
        $options = [
            'all' => ['selectd' => true, 'value' => 'All'],
            'on_Going' => ['value' => "On Going"],
            'approved' => ['value' => "Approved"],
            'declined' => ['value' => "Declined"],
        ];
        $employees = $this->user->userNames();
        foreach ($employees as $key => $value) {
            if ($value->id == $employee->id) {
                $employees[$key]['selected'] = true;
            }
        }
        $overtimes = $this->overtime;
        
        if (isset($request->filter)) {
            $filter = $request->filter;
            $options[$filter]['selected'] = true;
            if ($filter !== "all") {
                $overtimes = $overtimes->$filter();
            }
        }

        if (isset($request->overtime)) {
            $ot_id = $request->overtime;
            $overtimes = $overtimes->where('id', $ot_id);
        }

        $overtimes = $overtimes->where('user_id', $employee->id)->with('user')->get();
        $this->ot_inputs['user_id'] = $employee->id;
        $this->ot_inputs['disabled'] = true;
        $overtime = json_encode($this->ot_inputs);
        return view('request.overtime', compact('options', 'employees', 'overtimes', 'overtime'));
    }

    public function store (Request $request)
    {
        $data = $this->validate($request, [
            'user_id' => 'required|numeric',
            'date' => 'required|date|date_format:m/d/Y',
            'in' => 'required|date_format:H:i',
            'out' => 'required|date_format:H:i',
            'status' => 'required|numeric|max:0',
            'reason' => 'required|string|max:255',
        ]);
        
        $data = $this->toDBDate($data);
        $overtime = $this->overtime->create($data);

        $user = $overtime->user;
        if (!auth()->user()->admin) {
            // event(new LeaveRequest());
            $admins = Admin::all();
            $date = date('M d, Y', strtotime($overtime->date));

            $link = "/Overtime?overtime=$overtime->id";

            $notification = [
                'id' => $overtime->id,
                'type' => "Overtime Request",
                'by' => "{$user->lastname}, {$user->firstname}",
                'text' => "{$date}",
                'link' => "$link",
            ];
            foreach ($admins as $key => $admin) {
                $admin->user->notify(new NewRequest($notification));
            }
        }
    }

    public function update_status (Request $request, Overtime $overtime)
    {
        $data = $this->validate($request, [
            'status' => 'required|numeric|max:2',
        ]);

        $day = getdate(strtotime($overtime->date))['wday'];
        $user = $overtime->user;
        $dtr = $user->dtrs()->where('created_at', 'like',"{$overtime->date}%");
        
        if ($data['status'] == 1) {
            $this->DTR->process_overtime($overtime, $dtr);
        } elseif ($data['status'] == 2) {
            if ($dtr->onlyTrashed()->first()) {
                $dtr->onlyTrashed()->first()->restore();
            }
        }

        $date = date('M d, Y', strtotime($overtime->date));
        $status = ($data['status'] == 1) ? "Approved" : "Declined";
        $link = "/Overtime/$user->id?overtime=$overtime->id";

        $notification = [
            'id' => $overtime->id,
            'type' => "Overtime Request",
            'by' => "$status By " . auth()->user()->lastname . " " . auth()->user()->firstname,
            'text' => "{$date}",
            'link' => "$link",
        ];

        $user->notify(new NewRequest($notification));

        $overtime->update($data);
        
        return redirect()->back();
    }

    public function update (Request $request, Overtime $overtime)
    {
        $request['in'] = date('H:i', strtotime($request->in));
        $request['out'] = date('H:i', strtotime($request->out));
        
        $data = $this->validate($request, [
            'user_id' => 'required|numeric',
            'date' => 'required|date|date_format:m/d/Y',
            'in' => 'required|date_format:H:i',
            'out' => 'required|date_format:H:i',
            'status' => 'required|numeric|max:0',
            'reason' => 'required|string|max:255',
        ]);

        $data = $this->toDBDate($data);
        $overtime->update($data);
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
