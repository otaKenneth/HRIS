<?php

namespace App\Http\Controllers;

use App\DailyTimeRecord as DTR;
use App\Holiday;
use App\Request\Leave;
use App\Request\Overtime;
use App\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DailyTimeRecordController extends Controller
{
    //
    public function __construct()
    {
        $this->today = date('Y-m-d');
        $this->user = new User();
        $this->dtr = new DTR();
        $this->leave = new Leave();
        $this->holiday = new Holiday();
        $this->overtime = new Overtime();
        $this->dtr_date = null;
        $this->mon_range = [
            'Jan' => ['index' => 1, 'start' => 1, 'end' => 31], 
            'Feb' => ['index' => 2, 'start' => 1, 'end' => date('t', strtotime(date('Y') . "-02-01"))],
            'Mar' => ['index' => 3, 'start' => 1, 'end' => 31], 'Apr' => ['index' => 4, 'start' => 1, 'end' => 30],
            'May' => ['index' => 5, 'start' => 1, 'end' => 31], 'Jun' => ['index' => 6, 'start' => 1, 'end' => 30],
            'Jul' => ['index' => 7, 'start' => 1, 'end' => 31], 'Aug' => ['index' => 8, 'start' => 1, 'end' => 31],
            'Sep' => ['index' => 9, 'start' => 1, 'end' => 30], 'Oct' => ['index' => 10, 'start' => 1, 'end' => 31],
            'Nov' => ['index' => 11, 'start' => 1, 'end' => 30], 'Dec' => ['index' => 12, 'start' => 1, 'end' => 31],
        ];
        $this->filedrequests = [
            'otIn' => null,
            'otOut' => null,
            'leave' => null,
        ];
        $this->schedule = [
            'tag' => null,
            'in' => null,
            'breakOut' => null,
            'breakIn' => null,
            'out' => null,
        ];
        $this->time = [
            'in' => null,
            'breakOut' => null,
            'breakIn' => null,
            'out' => null,
        ];
        $this->tardiness = [
            'late' => null,
            'ut' => null,
        ];
        $this->workOn = null;
    }

    public function index (Request $request) {
        $this->authorize('viewAny', auth()->user());
        $emps = $this->user->userNames();
        $days = ['sun', 'mon', 'tue', 'wed', 'th', 'fri', 'sat'];
        $emp = null; $dtr = []; $dtr_view = []; $latest_schedule = null;
        $date_range = $this->today; $user_id = null;
        if (isset($request->employee)) {
            $date_range = $request->range;
            $do = ($request->date == 'down') ? "-1":"+1";
            $date_range = ($request->date == 'now') ? $this->today : date('Y-m-d', strtotime("$do months", strtotime($date_range)));
            $date = date('Y-m', strtotime($date_range));

            $emp = $request->employee;
            $emps[$emp]->selected = true;

            $user_id = $emps[$emp]->id;
            // get dtr per employee by year-month
            // dd($date);
            $dtr = $this->dtr->where('user_id', $user_id)->where('created_at', 'like', "$date%")->orderBy('created_at')->get();
            $dtr_view = $dtr;
        }
        // dd($dtr_view);
        return view('admin.dtr.index', compact('emps', 'dtr_view', 'days', 'date_range', 'user_id'));
    }
    
    public function show (Request $request, User $employee) 
    {
        $this->authorize('view', auth()->user());
        $days = ['sun', 'mon', 'tue', 'wed', 'th', 'fri', 'sat'];
        $date_range = ($request->range) ? $request->range:$this->today;
        
        if ($request->date) {
            $do = ($request->date == 'down') ? "-1" : "+1";
            $date_range = ($request->date == 'now') ? $this->today : date('Y-m-d', strtotime("$do months", strtotime($date_range)));
        }
        $date = date('Y-m', strtotime($date_range));

        $dtr = $this->dtr->where('user_id', $employee->id)->where('created_at', 'like', "$date%")->orderBy('created_at')->get();
        $dtr_view = $dtr;
        
        return view('timekeep.dtr.index', compact('employee', 'dtr_view', 'days', 'date_range'));
    }

    public function update (Request $request, User $employee) 
    {
        // dd($request);
        $effectivitydate = date('Y-m-d', strtotime($request->effectivitydate));
        $boundarydate = date('Y-m-d', strtotime($request->boundarydate));
        $days = $request->day;
        $dtrs = (isset($request->boundarydate)) ? $employee->dtrs()->where('created_at', '>=', "$effectivitydate")->where('created_at', '<', "$boundarydate")->get() : $employee->dtrs()->where('created_at', '>=', "$effectivitydate")->get();
        
        foreach ($dtrs as $key => $dtr) {
            if ($days[$dtr->day]) {
                $this->setDefaultValues();
                $this->dtr_date = date('Y-m-d', strtotime($dtr->created_at));
                $day = getdate()['wday'];

                $this->setSchedule($employee, $this->dtr_date, $dtr->day);
                $this->setTime($employee, $this->dtr_date);
                $this->setRequest($employee, $this->dtr_date);
                $this->setTardiness();
                $total = $this->total();

                $data = [
                    'tag' => json_encode($this->schedule['tag']),
                    'day' => $dtr->day,
                    'schedule_in' => $this->schedule['in'],
                    'schedule_breakOut' => $this->schedule['breakOut'],
                    'schedule_breakIn' => $this->schedule['breakIn'],
                    'schedule_out' => $this->schedule['out'],
                    'in'    => $this->time['in'],
                    'breakOut'    => $this->time['breakOut'],
                    'breakIn'    => $this->time['breakIn'],
                    'out'    => $this->time['out'],
                    'workOn' => $this->workOn,
                    'late'  => $this->tardiness['late'],
                    'otIn'  => $this->filedrequests['otIn'],
                    'otOut' => $this->filedrequests['otOut'],
                    // 'overbreak' => $this->overbreak(),
                    'leave' => $this->filedrequests['leave'],
                    'undertime' => $this->tardiness['ut'],
                    'total' => $total,
                    'regular' => ($total >= 8) ? 8.00 : $total,
                ];
                // dd($data);
                $employee->dtrs()->where('user_id', $employee->id)->where('created_at', $dtr->created_at)->update($data);
            } 
        }
    }

    public function processMyDTR ($employee)
    {
        $day = getdate()['wday'];

        $this->setSchedule($employee, $this->today, $day);
        $this->setTime($employee, $this->today);
        $this->setRequest($employee, $this->today);
        $this->setTardiness();
        $total = $this->total();
        
        $data = [
            'tag' => json_encode($this->schedule['tag']),
            'day' => $day,
            'schedule_in' => $this->schedule['in'],
            'schedule_breakOut' => $this->schedule['breakOut'],
            'schedule_breakIn' => $this->schedule['breakIn'],
            'schedule_out' => $this->schedule['out'],
            'in'    => $this->time['in'],
            'breakOut'    => $this->time['breakOut'],
            'breakIn'    => $this->time['breakIn'],
            'out'    => $this->time['out'],
            'workOn' => $this->workOn,
            'late'  => $this->tardiness['late'],
            'otIn'  => $this->filedrequests['otIn'],
            'otOut' => $this->filedrequests['otOut'],
            // 'overbreak' => $this->overbreak(),
            'leave' => $this->filedrequests['leave'],
            'undertime' => $this->tardiness['ut'],
            'total' => $total,
            'regular' => ($total >= 8) ? 8.00 : $total,
        ];

        $dtr = $employee->dtrs()->where('user_id', $employee->id)->where('created_at', 'like', "{$this->today}%")->first();
        if ($dtr) {
            $dtr->update($data);
        }else{
            $employee->dtrs()->create($data);
        }
    }

    public function processPrevDate ($user)
    {
        $employee = $this->user->find($user->id);
        $start = date("Y") . "-" . date('m', strtotime($this->today)). "-01";
        // $end = date('t', strtotime($this->today));
        $period = new DatePeriod(
            new DateTime($start),
            new DateInterval('P1D'),
            new DateTime($this->today)
        );
        // $dtrs = $this->dtr->where('user_id', $user->id)->whereBetween('created_at', [$start, $this->today])->get();
        // dd($dtrs);
        $this->processInPeriod($period, $employee);
    }

    private function processInPeriod ($period, $employee)
    {
        $this->processDate($employee, $period->start);
        foreach ($period as $key => $value) {
            $this->processDate($employee, $value);
        }
    }

    public function process ($date, User $employee)
    {
        $start = date("Y") . "-" . date('m', strtotime($date)) . "-01";
        $end = date("Y") . "-" . date('m', strtotime("+1 months", strtotime($date))) . "-01";
        if ($date == $this->today) {
            $end = date("Y-m-d", strtotime('+1 days', strtotime($date)));
        }

        $period = new DatePeriod(
            new DateTime($start),
            new DateInterval('P1D'),
            new DateTime($end)
        );

        $this->processInPeriod($period, $employee);   

        return response(['processed' => true]);
    }

    public function process_override ($employee, $date, $day, $override, $dtr)
    {
        $this->setSchedule($employee, $date, $day);
        $this->setTime($employee, $date, $override);
        $this->setRequest($employee, $date);
        $this->setTardiness();
        $total = $this->total();
        
        $data = [
            'tag' => json_encode($this->schedule['tag']),
            'day' => $day,
            'schedule_in' => $this->schedule['in'],
            'schedule_breakOut' => $this->schedule['breakOut'],
            'schedule_breakIn' => $this->schedule['breakIn'],
            'schedule_out' => $this->schedule['out'],
            'in'    => $this->time['in'],
            'breakOut'    => $this->time['breakOut'],
            'breakIn'    => $this->time['breakIn'],
            'out'    => $this->time['out'],
            'workOn' => $this->workOn,
            'late'  => $this->tardiness['late'],
            'otIn'  => $this->filedrequests['otIn'],
            'otOut' => $this->filedrequests['otOut'],
            // 'overbreak' => $this->overbreak(),
            'leave' => $this->filedrequests['leave'],
            'undertime' => $this->tardiness['ut'],
            'total' => $total,
            'regular' => ($total >= 8) ? 8.00 : $total,
        ];

        // dd($data);

        if ($dtr->where('tag', '!=', "Overriden")->first()) {
            $dtr->where('tag', '!=', "Overriden")->first()->delete();
        }

        $employee->dtrs()->updateOrCreate([
            'user_id' => $employee->id,
            'tag' => "Overriden",
            'day' => $day,
            'created_at' => $override->date,
        ], $data);
    }

    public function process_overtime ($overtime, $dtr)/* @ approved */
    {
        $dtr = $dtr->first();

        $diff = date_diff(date_create($dtr->out), date_create($overtime->out));
        if ($diff->format("%R%H.%i") > 0) {
            $data = [
                'tag' => array_merge($dtr->tag, ["ot"]),
                'otIn'  => $overtime->in,
                'otOut' => $overtime->out,
            ];
            
            $dtr->update($data);
        }

    }

    public function process_holiday ($employee, $holiday)
    {
        $period = new DatePeriod(
            new DateTime($holiday->from),
            new DateInterval('P1D'),
            new DateTime($holiday->to)
            // new DateTime($holiday['from']),
            // new DateInterval('P1D'),
            // new DateTime($holiday['to'])
        );
        // dd($period);
        $this->processInPeriod($period, $employee);
    }

    public function processDate ($employee, $value)
    {
        $this->setDefaultValues();
        $date = $value->format('Y-m-d');
        $day = getdate(strtotime($date))['wday'];
        
        $this->setSchedule($employee, $date, $day);
        $this->setTime($employee, $date);
        $this->setRequest($employee, $date);
        $this->setTardiness();
        $total = $this->total();

        $data = [
            'tag' => json_encode($this->schedule['tag']),
            'day' => $day,
            'schedule_in' => $this->schedule['in'],
            'schedule_breakOut' => $this->schedule['breakOut'],
            'schedule_breakIn' => $this->schedule['breakIn'],
            'schedule_out' => $this->schedule['out'],
            'in'    => $this->time['in'],
            'breakOut'    => $this->time['breakOut'],
            'breakIn'    => $this->time['breakIn'],
            'out'    => $this->time['out'],
            'workOn' => $this->workOn,
            'late'  => $this->tardiness['late'],
            'otIn'  => $this->filedrequests['otIn'],
            'otOut' => $this->filedrequests['otOut'],
            // 'overbreak' => $this->overbreak(),
            'leave' => trim($this->filedrequests['leave']),
            'undertime' => $this->tardiness['ut'],
            'total' => $total,
            'regular' => ($total >= 8) ? 8.00 : $total,
            'created_at' => $date,
        ];

        $employee->dtrs()->updateOrCreate([
            'day' => $day,
            'created_at' => $date
        ],$data);
    }

    private function setDefaultValues ()
    {
        $this->filedrequests = [
            'otIn' => null,
            'otOut' => null,
            'leave' => null,
        ];
        $this->schedule = [
            'tag' => null,
            'in' => null,
            'breakOut' => null,
            'breakIn' => null,
            'out' => null,
        ];
        $this->time = [
            'in' => null,
            'breakOut' => null,
            'breakIn' => null,
            'out' => null,
        ];
        $this->tardiness = [
            'late' => null,
            'ut' => null,
        ];
        $this->workOn = null;
    }

    private function setSchedule($user, $date, $day)
    {
        $sched = $user->schedules()->where('effectivitydate', '<=', "{$date}")->where('day', $day)->first();
        
        if ($sched) {
            $shift = $sched->shift()->first();
            // dd($override);
            $this->schedule['tag'][] = $shift->code;
            $this->schedule['in'] = $shift->in;
            $this->schedule['breakOut'] = $shift->breakOut;
            $this->schedule['breakIn'] = $shift->breakIn;
            $this->schedule['out'] = $shift->out;
            if (date("H", strtotime($shift->in)) >= "18") $this->schedule['tag'][] = "nd";
        }
    }

    private function setTime($user, $date, $override = null)
    {
        $this->time['in'] = $user->ins()->where('created_at', 'like', "{$date}%")->first()['created_at'];
        $this->time['breakOut'] = $user->breakOuts()->where('created_at', 'like', "{$date}%")->first()['created_at'];
        $this->time['breakIn'] = $user->breakIns()->where('created_at', 'like', "{$date}%")->first()['created_at'];
        $this->time['out'] = $user->outs()->where('created_at', 'like', "{$date}%")->first()['created_at'];

        if ($override !== null) {
            $this->schedule['tag'][] = "Overriden";
            $this->time['in'] = (in_array($override->override, ['all', 'in', 'inout'])) ? $override->in : $this->time['in'];
            $this->time['breakOut'] = (in_array($override->override, ['all', 'breakOut', 'breaks'])) ? $override->breakOut : $this->time['breakOut'];
            $this->time['breakIn'] = (in_array($override->override, ['all', 'breakIn', 'breaks'])) ? $override->breakIn : $this->time['breakIn'];
            $this->time['out'] = (in_array($override->override, ['all', 'out', 'inout'])) ? $override->out : $this->time['out'];
        }

        if (!in_array("off", $this->schedule['tag'])) {
            if ($this->time['in'] == null && $this->time['out'] == null) $this->schedule['tag'][] = "absent";
        }
    }

    private function setRequest($user, $date)
    {
        $overtime = $user->overtimes()->where('date', $date)->where('status', 1)->first();
        if ($overtime) {
            $this->filedrequests['otIn'] = $overtime->in;
            $this->filedrequests['otOut'] = $overtime->out;
            $this->schedule['tag'][] = "ot";
        }
        $leave = $user->leaves()->where('from', '<=', "{$date}")->where('to', '>=', "{$date}")->where('status', 1)->first();
        if ($leave) {
            $range = $leave->leaveRanges()->where('date', $date)->first();
            $this->filedrequests['leave'] = $leave->type;
            $this->schedule['tag'] = [($range->pay) ? "paid $leave->type" : $leave->type];
        }
        $holiday = Holiday::where('from', '>=', "$date")->where('to', '<=', "$date")->first();
        if ($holiday) {
            if (in_array("absent", $this->schedule['tag'])) $this->schedule['tag'] = [$holiday->type];
            if ($this->time['in'] !== null && $this->time['out'] !== null) {
                $this->workOn = $holiday->type;
            }
        }
    }

    private function setTardiness()
    {
        $this->tardiness = [
            'late' => $this->late(),
            'ut' => $this->undertime(),
        ];
    }

    private function late()
    {
        if ($this->time['in'] !== null) {
            $late = date_diff(date_create($this->schedule['in']), date_create($this->time['in']));
            $late = $late->format("%R%H.%i");
            return (floatval($late) <= 0) ? null : $late;
        }
    }

    private function undertime()
    {
        if ($this->time['in'] !== null && $this->time['out'] !== null) {
            if (in_array("flexitime", $this->schedule['tag'])) {
                $time = date_add(date_create($this->time['in']), date_interval_create_from_date_string("8 hours"));
                $undertime = date_diff(date_create($this->time['out']), date_create($time->format("H:i:s")));
                $undertime = $undertime->format("%R%H.%i");
                return (floatval($undertime) <= 0) ? null : $undertime;
            }else{
                if ($this->schedule['out'] !== null) {
                    $undertime = date_diff(date_create($this->time['out']), date_create($this->schedule['out']));
                    $undertime = $undertime->format("%R%H.%i");
                    return (floatval($undertime) <= 0) ? null : $undertime;
                }
            }
        }
    }

    private function overbreak()
    {
        if ($this->schedule['breakOut'] !== null) {
            if ($this->time['breakOut'] !== null) {
                $temp = date_diff(date_create($this->schedule['breakOut']), date_create($this->time['breakOut']));
                $temp = $temp->format("%R%H.%i");
                if (floatval($temp) > 0) {
                    $sched_b_in = date_add(date_create($this->schedule['breakIn']), $temp);
                    $overbreak = date_diff(date_create($sched_b_in), date_create($this->time['breakIn']));
                    $overbreak = $overbreak->format("%R%H.%i");
                    return (floatval($overbreak) > 0) ? null : $overbreak;
                }
            }
        }
    }

    private function total()
    {
        if ($this->time['in'] !== null && $this->time['out'] !== null) {
            $total = date_diff(date_create($this->time['in']), date_create($this->time['out']));
            $total = $total->format("%R%H.%i");
            return $total -= ($total > 4) ? 1 : 0;
        }
    }
}
