<?php

namespace App\Http\Controllers\Payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payroll\Payroll;
use App\Payroll\Setting;
use App\Rules\hasPercent;
use App\User;
use Illuminate\Support\Arr;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->user = new User();
        $this->payroll = new Payroll();
    }

    public function index ()
    {
        $this->authorize('viewAny', User::class);
        $payroll = Setting::payroll()->get();
        $arr = [];
        foreach ($payroll as $key => $value) {
            data_fill($arr, $value['key'], $value['value']);
        }
        // dd($arr);
        return view('payroll.settings', compact('arr'));
    }

    public function update (Request $request)
    {
        $data = $this->validate($request, [
            'defaults.from' => 'required|numeric|max:31',
            'defaults.every' => 'required|numeric|max:31',
            'defaults.efectivitydate' => 'required|date|date_format:m/d/Y',
            'rh.regular.unworked' => ['required', 'string', new hasPercent],
            'rh.regular.worked' => ['required', 'string', new hasPercent],
            'rh.regular.worked&rd' => ['required', 'string', new hasPercent],
            'sh.unworked' => ['nullable', 'string', new hasPercent],
            'sh.worked' => ['required', 'string', new hasPercent],
            'sh.worked&rd' => ['required', 'string', new hasPercent],
            'ot.regular' => ['required', 'string', new hasPercent],
            'ot.nd.regular' => ['required', 'string', new hasPercent],
            'ot.restday' => ['required', 'string', new hasPercent],
            'ot.nd.restday' => ['required', 'string', new hasPercent],
            'ot.SH' => ['required', 'string', new hasPercent],
            'ot.nd.SH' => ['required', 'string', new hasPercent],
            'ot.SH&rd' => ['required', 'string', new hasPercent],
            'ot.nd.SH&rd' => ['required', 'string', new hasPercent],
            'ot.RH' => ['required', 'string', new hasPercent],
            'ot.nd.RH' => ['required', 'string', new hasPercent],
            'ot.RH&rd' => ['required', 'string', new hasPercent],
            'ot.nd.RH&rd' => ['required', 'string', new hasPercent],
        ]);
        
        $payroll = Arr::dot([
            'payroll' => $data
        ]);

        $this->create_payroll_dates($data);
        foreach ($payroll as $key => $value) {
            Setting::updateOrCreate([
                'key' => $key
            ],[
                'key' => $key,
                'value' => $value,
            ]);
        }

        return redirect()->back();
    }

    private function create_payroll_dates ($data)
    {
        $start = $data['defaults']['from'];
        $iteration = $data['defaults']['every'] - 1;
        $start_mon = date('Y-m', strtotime($data['defaults']['efectivitydate']));
        $year = date('Y', strtotime($data['defaults']['efectivitydate']));
        $start_date = "$start_mon-$start";
        $start_year = $year;
        $this->payroll->where("range_from", 'like', "$start_year%")->delete();
        $from = date('Y-m-d', strtotime($start_date));

        while ($start_year == $year) {
            $date_interval = date_add(date_create($from), date_interval_create_from_date_string("$iteration days"));
            $to = $date_interval->format('Y-m-d');
            $new_from = date_add(date_create($to), date_interval_create_from_date_string("1 days"));

            $range = date("M d, Y", strtotime($from)) . " to " . date("M d, Y", strtotime($to));
            foreach ($this->user->get() as $user)
            {
                $salary = $user->salary;
                if ($salary) {
                    $user->payrolls()->create([
                        'type' => $salary->salary_type,
                        'tndp' => $salary->tndp,
                        'per_min' => $salary->per_min,
                        'hourly' => $salary->hourly,
                        'daily' => $salary->daily,
                        'half' => $salary->half,
                        'monthly' => $salary->monthly,
                        'allowance' => $salary->allowance,
                        'allowance_type' => $salary->allowance_type,
                        'range' => $range,
                        'range_from' => $from,
                        'range_to' => $to
                    ]);
                }
            }

            $from = $new_from->format('Y-m-d');
            $year = date('Y', strtotime($from));
        }
    }
}
