@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped table-inverse table-responsive-sm">
            <thead class="thead-inverse thead-dark thead-sticky">
                <tr>
                    <th colspan="16">
                        <form id="payroll-form" action="{{url("/Payroll/Computation")}}" method="get">
                            <div class="form-group m-0" style="width: 250px;"
                                onchange="setRange(); function setRange() {
                                    $('#payroll-form').submit();
                                }"
                            >
                                <select class="custom-select" name="range" id="range">
                                    @foreach ($ranges as $key => $range)
                                        <option value="{{$key}}" @isset($range['selected'])
                                            @if ($range['selected'])
                                                selected
                                            @endif
                                        @endisset>{{$range['value']}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary d-none">Submit</button>
                            </div>
                        </form>
                        {{-- <a href="{{url("/Payroll/Process")}}">Process</a> --}}
                    </th>
                </tr>
                <tr>
                    <th rowspan="2" class="align-middle text-center">#</th>
                    <th rowspan="2" class="align-middle text-center">Employee</th>
                    <th rowspan="2" class="align-middle text-center">Salary</th>
                    <th rowspan="2" class="align-middle text-center">Allowance</th>
                    <th rowspan="2" class="align-middle text-center">Wk Dys</th>
                    <th rowspan="2" class="align-middle text-center" data-toggle="tooltip" data-placement="bottom" title="Absent"><i class="fa fa-user-times text-red-500" aria-hidden="true"></i></th>
                    <th rowspan="2" class="align-middle text-center" data-toggle="tooltip" data-placement="bottom" title="Late">L</th>
                    <th rowspan="2" class="align-middle text-center" data-toggle="tooltip" data-placement="bottom" title="Undertime">UT</th>
                    <th rowspan="2" class="align-middle text-center" data-toggle="tooltip" data-placement="bottom" title="Overtime">OT</th>
                    <th colspan="2" class="align-middle text-center">SL</th>
                    <th colspan="2" class="align-middle text-center">VL</th>
                    <th rowspan="2" class="align-middle text-center">RH</th>
                    <th rowspan="2" class="align-middle text-center">SH</th>
                    <th rowspan="2" class="align-middle text-center">Total</th>
                </tr>
                <tr>
                    <th class="align-middle text-center" data-toggle="tooltip" data-placement="bottom" title="Paid"><i class="fa fa-check text-green-300" aria-hidden="true"></i></th>
                    <th class="align-middle text-center" data-toggle="tooltip" data-placement="bottom" title="Unpaid"><i class="fa fa-times text-red-500" aria-hidden="true"></i></th>
                    <th class="align-middle text-center" data-toggle="tooltip" data-placement="bottom" title="Paid"><i class="fa fa-check text-green-300" aria-hidden="true"></i></th>
                    <th class="align-middle text-center" data-toggle="tooltip" data-placement="bottom" title="Unpaid"><i class="fa fa-times text-red-500" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payrolls as $key => $payroll)
                    <tr class="text-xs">
                        <td>{{$key+1}}</td>
                        <td>
                            <div style="width: 70px;">
                                {{$payroll->user->lastname}}, {{$payroll->user->firstname}} {{$payroll->user->middlename}}
                            </div>
                        </td>
                        <td>
                            <div style="width: 150px">
                                <div class="row m-0">
                                    <span class="font-semibold col-6 m-0 p-0">Type:</span> <span>{{$payroll->type}}</span>
                                </div>
                                <div class="row m-0">
                                    <span class="font-semibold col-6 m-0 p-0">Per Min:</span> <span><i class="fas fa-ruble-sign"></i>
                                        {{number_format($payroll->per_min, 2)}}</span>
                                </div>
                                <div class="row m-0">
                                    <span class="font-semibold col-6 m-0 p-0">Hourly:</span> <span><i class="fas fa-ruble-sign"></i>
                                        {{number_format($payroll->hourly, 2)}}</span>
                                </div>
                                <div class="row m-0">
                                    <span class="font-semibold col-6 m-0 p-0">Daily:</span> <span><i class="fas fa-ruble-sign"></i>
                                        {{number_format($payroll->daily, 2)}}</span>
                                </div>
                                <div class="row m-0">
                                    <span class="font-semibold col-6 m-0 p-0">Half:</span> <span><i class="fas fa-ruble-sign"></i>
                                        {{number_format($payroll->half, 2)}}</span>
                                </div>
                                <div class="row m-0">
                                    <span class="font-semibold col-6 m-0 p-0">Monthly:</span> <span><i class="fas fa-ruble-sign"></i>
                                        {{number_format($payroll->monthly, 2)}}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="width: 120px;">
                                <div class="row m-0">
                                    <span class="font-semibold col-6 m-0 p-0">{{$payroll->allowance_type}}</span> <span><i class="fas fa-ruble-sign"></i> {{number_format($payroll->allowance, 2)}}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($payroll->work_days !== null)
                                <div style="width: 120px">
                                    @foreach (json_decode($payroll->work_days) as $key => $item)
                                        <div class="row m-0">
                                            @if ($item->value > 0)
                                            <span class="font-semibold col-6 m-0 p-0">{{$key}}</span> <span><i class="fas fa-ruble-sign"></i>
                                                {{number_format($item->value, 2)}}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>{{$payroll->absences}}</td>
                        <td>{{$payroll->lates}}</td>
                        <td>{{$payroll->undertimes}}</td>
                        <td>
                            @if ($payroll->ot !== null)
                                <div style="@if ($payroll->total_ot > 0)
                                    width: 100px
                                @endif">
                                    @foreach (json_decode($payroll->ot) as $key => $item)
                                        <div class="row m-0">
                                            @if ($item->count > 0)
                                            <span class="font-semibold col-6 m-0 p-0">{{$key}}</span> <span><i class="fas fa-ruble-sign"></i>
                                                {{number_format($item->value, 2)}}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>{{json_decode($payroll->sl)->paid}}</td>
                        <td>{{json_decode($payroll->sl)->unpaid}}</td>
                        <td>{{json_decode($payroll->vl)->paid}}</td>
                        <td>{{json_decode($payroll->vl)->unpaid}}</td>
                        <td>{{$payroll->RH}}</td>
                        <td>{{$payroll->SH}}</td>
                        <td style="width: 100px"><i class="fas fa-ruble-sign"></i> {{number_format($payroll->total, 2)}}</td>
                    </tr>
                @empty
                    <tr>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection