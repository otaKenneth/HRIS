@extends('layouts.app')

@section('content')
    <form id="payroll-form" action="{{url("/Payroll/PaySlip")}}" method="get">
        <div class="form-group m-0" style="width: 250px;" onchange="setRange(); function setRange() {
                                        $('#payroll-form').submit();
                                    }">
            <select class="custom-select" name="range" id="range">
                @foreach ($ranges as $key => $range)
                <option value="{{$key}}" @isset($range['selected']) @if ($range['selected']) selected @endif @endisset>
                    {{$range['value']}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary d-none">Submit</button>
        </div>
    </form>
    <div class="container row">
        @forelse ($payrolls as $payroll)
            <div class="card col-md-6 mb-2" style="height: max-content">
                <div class="card-body p-0">
                    <div class="card-title">
                        <h5>{{$payroll->user->lastname}}, {{$payroll->user->firstname}} {{$payroll->user->middlename}}</h5>
                        <div class="d-flex justify-content-between">
                            <div><span class="font-semibold">Position:</span> {{$payroll->user->position->value}}</div>
                            <div class="font-semibold">{{ucwords($payroll->type, " ")}} Salary</div>
                            <div><span class="font-semibold">Monthly:</span> <i class="fas fa-ruble-sign"></i>{{number_format($payroll->monthly, 2)}}</div>
                        </div>
                    </div>
                    <div class="row m-0">
                        <table class="table col-6">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center">Additions</th>
                                </tr>
                                <tr>
                                    <th>Label</th>
                                    <th>#</th>
                                    <th class="text-center"><i class="fas fa-ruble-sign"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (json_decode($payroll->work_days) as $key => $item)
                                    @if ($item->value > 0)
                                        <tr>
                                            <td class="font-semibold">{{ucwords($key, " ")}}</td>
                                            <td>{{$item->count}}</td>
                                            <td class="text-end"><i class="fas fa-ruble-sign"></i> {{number_format($item->value, 2)}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td class="font-semibold text-xs">Allowance</td>
                                    <td></td>
                                    <td class="text-end"><i class="fas fa-ruble-sign"></i> {{number_format($payroll->total_allowance, 2)}}</td>
                                </tr>
                                @if ($payroll->total_paid_sl > 0)
                                    <tr>
                                        <td class="font-semibold text-xs">SL</td>
                                        <td>{{json_decode($payroll->sl)->paid}}</td>
                                        <td class="text-end"><i class="fas fa-ruble-sign"></i> {{number_format($payroll->total_paid_sl, 2)}}</td>
                                    </tr>
                                @endif
                                @if ($payroll->total_paid_vl > 0)
                                    <tr>
                                        <td class="font-semibold text-xs">VL</td>
                                        <td>{{json_decode($payroll->vl)->paid}}</td>
                                        <td class="text-end"><i class="fas fa-ruble-sign"></i> {{number_format($payroll->total_paid_vl, 2)}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-center font-semibold">OT</td>
                                </tr>
                                @foreach (json_decode($payroll->ot) as $key => $item)
                                    @if (isset($item->value) && $item->value > 0)
                                        <tr>
                                            <td class="font-semibold">{{ucwords($key, " ")}}</td>
                                            <td>{{$item->count}}</td>
                                            <td><i class="fas fa-ruble-sign"></i> {{number_format($item->value, 2)}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table col-6">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center">Deductions</th>
                                </tr>
                                <tr>
                                    <th>Label</th>
                                    <th>#</th>
                                    <th class="text-center"><i class="fas fa-ruble-sign"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-semibold text-xs">Absences</td>
                                    <td>{{$payroll->absences}}</td>
                                    <td class="text-end">{{number_format($payroll->absences * $payroll->daily, 2)}}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold text-xs">Late</td>
                                    <td>{{$payroll->lates}}</td>
                                    <td class="text-end">{{number_format($payroll->lates * $payroll->hourly, 2)}}</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold text-xs">Undertime</td>
                                    <td>{{$payroll->undertimes}}</td>
                                    <td class="text-end">{{number_format($payroll->undertimes * $payroll->hourly, 2)}}</td>
                                </tr>
                                @if ($payroll->type == "monthly")
                                    @if ($payroll->total_paid_sl > 0)
                                        <tr>
                                            <td class="font-semibold text-xs">SL</td>
                                            <td>{{json_decode($payroll->sl)->paid}}</td>
                                            <td class="text-end"><i class="fas fa-ruble-sign"></i> {{number_format($payroll->total_paid_sl, 2)}}</td>
                                        </tr>
                                    @endif
                                    @if ($payroll->total_paid_vl > 0)
                                        <tr>
                                            <td class="font-semibold text-xs">VL</td>
                                            <td>{{json_decode($payroll->vl)->paid}}</td>
                                            <td class="text-end"><i class="fas fa-ruble-sign"></i> {{number_format($payroll->total_paid_vl, 2)}}</td>
                                        </tr>
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <v-divider></v-divider>
                    <div class="d-flex justify-content-between">
                        <span class="font-semibold">Total</span>
                        <span><i class="fas fa-ruble-sign"></i>{{number_format($payroll->total, 2)}}</span>
                    </div>
                </div>
            </div>
        @empty
            <div></div>
        @endforelse
    </div>
@endsection