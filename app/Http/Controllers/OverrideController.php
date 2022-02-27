<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Events\LeaveRequest;
use App\Notifications\NewRequest;
use App\Request\Override;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class OverrideController extends Controller
{
    //
    public function __construct()
    {
        $this->override = new Override();
        $this->user = new User();
        $this->DTR = new DailyTimeRecordController();
        $this->check = ['date'];
        $this->options = [
            'all' => [
                'value' => "All"
            ],
            'on_Going' => [
                'value' => "On Going"
            ],
            'approved' => [
                'value' => "Approved"
            ],
            'declined' => [
                'value' => "Declined"
            ],
        ];
        $this->or_opts = [
            'all' => [
                'value' => "All"
            ],
            'inout' => [
                'value' => "In-Out"
            ],
            'breaks' => [
                'value' => "Breaks"
            ],
            'in' => [
                'value' => "In"
            ],
            'out' => [
                'value' => "Out"
            ],
            'breakOut' => [
                'value' => "Break-Out"
            ],
            'breakIn' => [
                'value' => "Break-In"
            ],
        ];
        $this->override_inputs = [
            'user_id' => 0,
            'status' => 0,
            'date' => null,
            'override' => 'all',
            'in' => null,
            'out' => null,
            'breakOut' => null,
            'breakIn' => null,
            'disabled' => false,
        ];
    }

    public function index (Request $request)
    {
        $this->authorize('viewAny', auth()->user());
        $options = $this->options;
        $or_opts = $this->or_opts;
        $employees = $this->user->userNames();
        $overrides = $this->override;
        if (isset($request->filter)) {
            $filter = $request->filter;
            $opt = $filter[0]; $or_opt = $filter[1];

            $overrides = ($opt !== "all") ? $overrides->$opt () : $overrides;
            $overrides = ($or_opt !== "all") ? $overrides->$or_opt () : $overrides;

            $options[$opt]['selected'] = true;
            $or_opts[$or_opt]['selected'] = true;
        }

        if (isset($request->employee)) {
            if ($request->employee !== "all") {
                $emp = $request->employee;
                foreach ($employees as $key => $value) {
                    if ($value->id == $emp) {
                        $employees[$key]['selected'] = true;
                    }
                }
                $overrides = $overrides->where('user_id', $emp);
            }
        }

        if (isset($request->override)) {
            $oride_id = $request->override;
            $overrides = $overrides->where('id', $oride_id);
        }

        $overrides = $overrides->orderBy('created_at', 'DESC')->with('user')->get();
        $override = json_encode($this->override_inputs);
        return view('admin.request.override', compact('overrides', 'options', 'or_opts', 'employees', 'override'));
    }

    public function show (Request $request, User $employee)
    {
        $options = $this->options;
        $or_opts = $this->or_opts;
        $employees = $this->user->userNames();
        foreach ($employees as $key => $value) {
            if ($value->id == $employee->id) {
                $employees[$key]['selected'] = true;
            }
        }
        $overrides = $this->override;
        if (isset($request->filter)) {
            $filter = $request->filter;
            $opt = $filter[0];
            $or_opt = $filter[1];

            $overrides = ($opt !== "all") ? $overrides->$opt() : $overrides;
            $overrides = ($or_opt !== "all") ? $overrides->$or_opt() : $overrides;

            $options[$opt]['selected'] = true;
            $or_opts[$or_opt]['selected'] = true;
        }

        if (isset($request->override)) {
            $oride_id = $request->override;
            $overrides = $overrides->where('id', $oride_id);
        }

        $overrides = $overrides->where('user_id', $employee->id)->orderBy('created_at', 'DESC')->with('user')->get();
        $this->override_inputs['user_id'] = $employee->id;
        $this->override_inputs['disabled'] = true;
        $override = json_encode($this->override_inputs);
        return view('request.override', compact('overrides', 'options', 'or_opts', 'employees', 'override'));
    }

    public function store (Request $request)
    {
        $data = $this->validate($request, [
            'user_id' => 'required|numeric|min:1',
            'date' => 'required|date|date_format:m/d/Y',
            'override' => 'required|string',
            'status' => 'required|numeric',
            'in' => [
                (in_array($request->override, ['all','in','inout'])) ? 'required':'nullable',
                'date_format:H:i'
            ],
            'breakOut' => [
                (in_array($request->override, ['all','breakOut','breaks'])) ? 'required':'nullable',
                'date_format:H:i'
            ],
            'breakIn' => [
                (in_array($request->override, ['all','breakIn','breaks'])) ? 'required':'nullable',
                'date_format:H:i'
            ],
            'out' => [
                (in_array($request->override, ['all','out','inout'])) ? 'required':'nullable',
                'date_format:H:i'
            ],
        ]);

        $data = $this->toDBDate($data);
        $override = $this->override->create($data);
        if (!auth()->user()->admin) {
            $user = $override->user;
            $date = date('M d, Y', strtotime($override->date));
            $link = "/Override?override=$override->id";
            
            $notification = [
                'id' => $override->id,
                'type' => "Override Request",
                'by' => "{$user->lastname}, {$user->firstname}",
                'text' => "{$date}",
                'link' => "$link",
            ];

            foreach (Admin::all() as $key => $admin) {
                $admin->user->notify(new NewRequest($notification));
            }
        }
    }

    public function update (Request $request, Override $override)
    {
        $request['in'] = date('H:i', $request->in);
        $request['breakOut'] = date('H:i', $request->breakOut);
        $request['breakIn'] = date('H:i', $request->breakIn);
        $request['out'] = date('H:i', $request->out);
        
        $data = $this->validate($request, [
            'date' => 'required|date|date_format:m/d/Y',
            'override' => 'required|string',
            'in' => [
                (in_array($request->override, ['all', 'in', 'inout'])) ? 'required' : 'nullable',
                'date_format:H:i'
            ],
            'breakOut' => [
                (in_array($request->override, ['all', 'breakOut', 'breaks'])) ? 'required' : 'nullable',
                'date_format:H:i'
            ],
            'breakIn' => [
                (in_array($request->override, ['all', 'breakIn', 'breaks'])) ? 'required' : 'nullable',
                'date_format:H:i'
            ],
            'out' => [
                (in_array($request->override, ['all', 'out', 'inout'])) ? 'required' : 'nullable',
                'date_format:H:i'
            ]
        ]);
        $data = $this->toDBDate($data);
        $override->update($data);
    }

    public function update_status (Request $request, Override $override)
    {
        $user = $override->user;
        $day = getdate(strtotime($override->date))['wday'];
        $data = $this->validate($request, [
            'status' => 'required|numeric|max:2'
        ]);
        $dtr = $user->dtrs()->where('created_at', "{$override->date}");

        if ($data['status'] == 1) {
            $this->DTR->process_override($user, $override->date, $day, $override, $dtr);
        }elseif ($data['status'] == 2) {
            if ($dtr->onlyTrashed()->first()) {
                $dtr->onlyTrashed()->first()->restore();
            }
        }

        $date = date('M d, Y', strtotime($override->date));
        $status = ($data['status'] == 1) ? "Approved" : "Declined";
        $link = "/Override/$user->id?override=$override->id";

        $notification = [
            'id' => $override->id,
            'type' => "Override Request",
            'by' => "$status By " . auth()->user()->lastname . " " . auth()->user()->firstname,
            'text' => "{$date}",
            'link' => "$link",
        ];

        $user->notify(new NewRequest($notification));

        $override->update($data);
        
        return redirect()->back();
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
