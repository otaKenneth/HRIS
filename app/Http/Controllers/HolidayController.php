<?php

namespace App\Http\Controllers;

use App\Events\CreateHolidayRecord;
use App\Models\Holiday;
use App\User;
use App\Http\Controllers\DailyTimeRecordController;
use Illuminate\Http\Request;

class HolidayController extends Controller
{

    public function __construct()
    {
        $this->user = new User();
        $this->DTR = new DailyTimeRecordController();
        $this->check = ['from', 'to'];
    }

    public function index(Request $request)
    {
        $options = [
            'all' => ['selected' => false, 'value' => 'All'],
            'RH' => ['value' => 'Regular Holiday'],
            'SH' => ['value' => 'Special Non-Working Holiday'],
        ];
        $holidays = [];
        if (isset($request->filter)) {
            $filter = $request->filter;
            if ($filter !== "all") {
                $holidays = Holiday::where('type', $filter)->get();
                $options[$filter]['selected'] = true;
            }
        } 
        if (count($holidays) == 0) {
            $holidays = Holiday::all();
        }
        return view('holiday', compact('options', 'holidays'));
    }

    public function store (Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required|string|max:190',
            'type' => 'required|string|max:2',
            'from' => 'required|date|date_format:m/d/Y',
            'to' => 'required|date|date_format:m/d/Y',
            'bg' => '',
            'color' => '',
        ]);

        $data = $this->toDBDate($data);
        
        // $holiday = $data;
        $holiday = Holiday::create($data);

        // foreach ($this->user->get() as $user) {
        //     $this->DTR->process_holiday($user, $holiday);
        // }
        event(new CreateHolidayRecord($holiday));
    }

    public function update (Request $request, Holiday $holiday)
    {
        $data = $this->validate($request, [
            'title' => 'required|string|max:190',
            'type' => 'required|string|max:2',
            'from' => 'required|date|date_format:m/d/Y',
            'to' => 'required|date|date_format:m/d/Y',
            'bg' => '',
            'color' => '',
        ]);

        $data = $this->toDBDate($data);
        $holiday->update($data);
        event(new CreateHolidayRecord($holiday));
    }

    public function destroy (Holiday $holiday)
    {
        $holiday->delete();
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
