<?php

namespace App\Http\Controllers\Payroll;

use Illuminate\Http\Request;
use App\User;
use App\Payroll\Payroll;
use App\Http\Controllers\Controller;

class PayslipController extends Controller
{
    public function __construct()
    {
        $this->user = new User();
        $this->payroll = new Payroll();
        $this->today = date('Y-m-d');
        $this->ranges = $this->payroll->ranges();
    }

    public function index (Request $request)
    {
        $this->authorize('viewAny', User::class);
        $ranges = [];
        $payrolls = $this->payroll;

        foreach ($this->ranges as $key => $value) {
            $ranges[$key]['value'] = $value->range;
            if (isset($request->range)) {
                if ($request->range == $key) {
                    $ranges[$key]['selected'] = true;
                    $payrolls = $payrolls->where("range", $ranges[$key]['value']);
                }
            } else {
                $ranges[0]['selected'] = true;
                $payrolls = $payrolls->where("range_from", '<=', $this->today)->where("range_to", ">=", $this->today);
            }
        }

        $payrolls = $payrolls->get();

        // dd($payrolls);
        return view('payroll.payslip', compact('payrolls', 'ranges'));
    }
}
