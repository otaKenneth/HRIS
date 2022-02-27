@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form id="dtr-form" action="/DTR" method="get">
        <input type="text" name="date" id="date" class="d-none" value="now">
        <input type="text" name="range" id="range" class="d-none" value="{{$date_range}}">
        <div class="form-group col-sm-3 m-0">
            <label for="employee">Employee: </label>
            <div class="row">
                <select class="selectpicker mx-1 border" name="employee" id="employee" data-live-search="true" title="Select one" 
                    onchange="submitForm(); function submitForm () {
                        $('#dtr-form').submit();
                    }">
                    @foreach ($emps as $key => $emp)
                        <option @if (isset($emp->selected))
                            selected
                        @endif class="dropdown-item text-dark" value="{{$key}}">{{$emp->name}}</option>
                    @endforeach
                </select>
                {{-- <a href="{{url("/DTR/$date_range/Employee/$user_id/Process")}}" class="btn btn-primary text-light" data-toggle="tooltip" data-placement="bottom" title="Process All"><i class="fa fa-repeat"></i></a> --}}
                <dtr range="{{$date_range}}" user_id="{{$user_id}}"></dtr>
            </div>
        </div>
    </form>
    <div style="height: 80vh; overflow: auto;">
        <table class="table table-inverse">
            <thead class="thead-inverse thead-sticky">
                <tr>
                    <th colspan="17" class="bg-light">
                        <button type="button" class="btn btn-primary" onclick="now(); function now () {
                            $('#dtr-form #date').val('now');
                            $('#dtr-form').submit();
                        }">Today</button>
                        <button type="button" class="btn border rounded-circle" onclick="down(); function down () {
                            $('#dtr-form #date').val('down');
                            $('#dtr-form').submit();
                        }">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <span>{{date('M, Y', strtotime($date_range))}} Record</span>
                        <button type="button" class="btn border rounded-circle" onclick="up(); function up () {
                            $('#dtr-form #date').val('up');
                            $('#dtr-form').submit();
                        }"><i class="fas fa-arrow-right"></i></button>
                    </th>
                </tr>
                <tr>
                    <th rowspan="2" class="bg-dark text-light align-middle">#</th>
                    <th rowspan="2" class="bg-dark text-light align-middle">Day</th>
                    <th colspan="4" class="text-center bg-green-400 text-dark">Schedule</th>
                    <th colspan="4" class="text-center bg-blue-500 text-dark">Data</th>
                    <th colspan="2" class="bg-dark text-light text-center">OT</th>
                    <th rowspan="2" class="bg-purple-700 align-middle text-light text-center">Work On</th>
                    <th colspan="2" class="text-center bg-red-400 text-dark">Tardiness</th>
                    <th rowspan="2" class="bg-dark text-light align-middle text-center">Leave</th>
                    <th rowspan="2" class="bg-dark text-light text-center align-middle">Total <small class="d-block text-center">Hrs. Rendered</small></th>
                </tr>
                <tr>
                    <th class="bg-green-300 text-center align-middle text-xs">In</th>
                    <th class="bg-green-300 text-center text-xs" data-toggle="tooltip" data-placement="bottom" title="Break-Out">BO</th>
                    <th class="bg-green-300 text-center text-xs" data-toggle="tooltip" data-placement="bottom" title="Break-In">BI</th>
                    <th class="bg-green-300 text-center text-xs align-middle">Out</th>
                    <th class="bg-blue-300 text-center align-middle text-xs">In</th>
                    <th class="bg-blue-300 text-center text-xs" data-toggle="tooltip" data-placement="bottom" title="Break-Out">BO</th>
                    <th class="bg-blue-300 text-center text-xs" data-toggle="tooltip" data-placement="bottom" title="Break-In">BI</th>
                    <th class="bg-blue-300 text-center text-xs align-middle">Out</th>
                    <th class="bg-light align-middle text-xs">In</th>
                    <th class="bg-light align-middle text-xs">Out</th>
                    {{-- <th>ND</th> --}}
                    {{-- <th class="bg-purple-300 text-center" data-toggle="tooltip" data-placement="bottom" title="Regular Holliday">RH</th>
                    <th class="bg-purple-300 text-center" data-toggle="tooltip" data-placement="bottom" title="Special Holiday">SH</th> --}}
                    <th class="bg-red-300 align-middle text-xs">Late</th>
                    <th class="bg-red-300 align-middle text-center text-xs" data-toggle="tooltip" data-placement="bottom" title="Undertime">UT</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($dtr_view as $record)
                        @if ($record['tag'] == 'off')
                            <tr class="text-xs bg-yellow-300">
                        @elseif (in_array("RH", json_decode($record['tag'])))
                            <tr class="text-xs bg-orange-600 text-light">
                        @elseif (in_array("SH", json_decode($record['tag'])))
                            <tr class="text-xs bg-green-600 text-light">
                        @elseif (in_array("paid SL", json_decode($record['tag'])))
                            <tr class="text-xs bg-green-400">
                        @elseif (in_array("SL", json_decode($record['tag'])))
                            <tr class="text-xs bg-green-300">
                        @elseif (in_array("paid VL", json_decode($record['tag'])))
                            <tr class="text-xs bg-purple-500">
                        @elseif (in_array("VL", json_decode($record['tag'])))
                            <tr class="text-xs bg-purple-400 text-light">
                        @elseif (in_array("absent", json_decode($record['tag'])))
                            <tr class="text-xs bg-red-500 text-light">
                        @else
                            <tr class="text-xs">
                        @endif
                            <td class="text-center">{{date('d', strtotime($record['created_at']))}}</td>
                            <td class="text-center">{{$days[$record['day']]}}</td>
                            <td class="text-center">
                                @if (isset($record['schedule_in']))
                                    {{date('h:i a', strtotime($record['schedule_in']))}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['schedule_breakOut']))
                                    {{date('h:i a', strtotime($record['schedule_breakOut']))}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['schedule_breakIn']))
                                    {{date('h:i a', strtotime($record['schedule_breakIn']))}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['schedule_out']))
                                    {{date('h:i a', strtotime($record['schedule_out']))}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['in']))
                                    {{date('h:i a', strtotime($record['in']))}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['breakOut']))
                                    {{date('h:i a', strtotime($record['breakOut']))}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['breakIn']))
                                    {{date('h:i a', strtotime($record['breakIn']))}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['out']))
                                    {{date('h:i a', strtotime($record['out']))}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['otIn']))
                                    {{date('h:i a', strtotime($record['otIn']))}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['otOut']))
                                    {{date('h:i a', strtotime($record['otOut']))}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['workOn']))
                                    {{$record['workOn']}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['late']))
                                    {{$record['late']}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['undertime']))
                                    {{$record['undertime']}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['leave']))
                                    {{$record['leave']}}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($record['total']))
                                    {{$record['total']}}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="17" class="text-center bg-red-300">No Results Found.</td>
                        </tr>
                    @endforelse
                </tbody>
        </table>
    </div>
</div>
@endsection