@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped table-inverse table">
        <thead class="thead-inverse thead-dark">
            <tr>
                <th class="align-middle">
                    <i class="fa fa-filter" aria-hidden="true"></i>
                </th>
                <th colspan="4">
                    <div class="d-flex">
                        <form action="/Override" method="get">
                            <select class="custom-select mx-1" style="width: 185px" name="filter[]">
                            @foreach ($options as $key => $option)
                                <option value="{{$key}}" @isset($option['selected'])
                                    @if ($option['selected'])
                                        selected
                                    @endif
                                @endisset>{{$option['value']}}</option>
                            @endforeach
                            </select>
                            <select class="custom-select mx-1" style="width: 185px" name="filter[]">
                            @foreach ($or_opts as $key => $or_opt)
                                <option value="{{$key}}" @isset($or_opt['selected'])
                                    @if ($or_opt['selected'])
                                        selected
                                    @endif
                                @endisset>{{$or_opt['value']}}</option>
                            @endforeach
                            </select>
                            <select class="selectpicker mx-1" data-live-search="true" name="employee" title="Search ...">
                                @foreach ($employees as $key => $employee)
                                    <option class="dropdown-item text-dark" value="{{$key}}" @isset($employee['selected'])
                                        @if ($employee['selected'])
                                            selected
                                        @endif
                                    @endisset>{{$employee->name}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </th>
                <th class="text-center">
                    <override-add :employees="{{$employees}}" :oride="{{$override}}"></override-add>
                </th>
            </tr>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Date</th>
                <th>Override</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($overrides as $key => $override)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$override->user->lastname}}, {{$override->user->firstname}} {{$override->user->middlename}}</td>
                        <td>{{date('M d, Y', strtotime($override->date))}}</td>
                        <td>
                            <div class="@if(!in_array($override->override, ['all','in','inout'])) d-none @endif">
                                <span class="font-semibold">In:</span> {{date('h:i a', strtotime($override->in))}}
                            </div>
                            <div class="@if(!in_array($override->override, ['all','breakOut','breaks'])) d-none @endif">
                                <span class="font-semibold">Break-Out:</span> {{date('h:i a', strtotime($override->breakOut))}}
                            </div>
                            <div class="@if(!in_array($override->override, ['all','breakIn','breaks'])) d-none @endif">
                                <span class="font-semibold">Break-In:</span> {{date('h:i a', strtotime($override->breakIn))}}
                            </div>
                            <div class="@if(!in_array($override->override, ['all','out','inout'])) d-none @endif">
                                <span class="font-semibold">Out:</span> {{date('h:i a', strtotime($override->out))}}
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-light" onclick="statusUp({{$key}}); function statusUp (key) {
                                                        $(`#status-form-${key} #status`).val('1');
                                                        $(`#status-form-${key}`).submit();
                                                    }" data-toggle="tooltip" data-placement="bottom" title="Approve">
                                <i class="fa {{($override->status == 1) ? 'fa-thumbs-up text-green-500':'fa-thumbs-o-up'}}" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-light" onclick="statusDown({{$key}}); function statusDown (key) {
                                                        $(`#status-form-${key} #status`).val('2');
                                                        $(`#status-form-${key}`).submit();
                                                    }" data-toggle="tooltip" data-placement="bottom" title="Decline">
                                <i class="fa {{($override->status == 2) ? 'fa-thumbs-down text-red-500':'fa-thumbs-o-down'}}" aria-hidden="true"></i>
                            </button>
                            <form id="status-form-{{$key}}" class="d-none" action="{{url("Override/$override->id/status")}}" method="post">
                                <input type="number" name="status" id="status">
                                @method('patch')
                                @csrf
                            </form>
                        </td>
                        <td class="text-center">
                            <override-actions :override="{{$override}}" :employees="{{$employees}}"></override-actions>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center bg-red-300">No Found Results.</td>
                    </tr>
                @endforelse
            </tbody>
    </table>
</div>    
@endsection