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
                        <form action="/Override/{{Auth::user()->id}}" method="get">
                            {{-- <span class="m-2">{{$employee->lastname}}, {{$employee->firstname}} {{$employee->middlename}}</span> --}}
                            <select class="custom-select mx-1" style="width: 185px" name="filter[]">
                                @foreach ($options as $key => $option)
                                <option value="{{$key}}" @isset($option['selected']) @if ($option['selected']) selected
                                    @endif @endisset>{{$option['value']}}</option>
                                @endforeach
                            </select>
                            <select class="custom-select mx-1" style="width: 185px" name="filter[]">
                                @foreach ($or_opts as $key => $or_opt)
                                <option value="{{$key}}" @isset($or_opt['selected']) @if ($or_opt['selected']) selected
                                    @endif @endisset>{{$or_opt['value']}}</option>
                                @endforeach
                            </select>
                            {{-- <select class="selectpicker mx-1" data-live-search="true" name="employee"
                                title="Search ...">
                                @foreach ($employees as $key => $employee)
                                <option class="dropdown-item text-dark" value="{{$key}}" @isset($employee['selected'])
                                    @if ($employee['selected']) selected @endif @endisset>{{$employee->name}}</option>
                                @endforeach
                            </select> --}}
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
                <td>You</td>
                <td>{{date('M d, Y', strtotime($override->date))}}</td>
                <td>
                    <div class="@if(!in_array($override->override, ['all','in','inout'])) d-none @endif"><span
                            class="font-semibold">In:</span> {{date('h:i a', strtotime($override->in))}}</div>
                    <div class="@if(!in_array($override->override, ['all','breakOut','breaks'])) d-none @endif"><span
                            class="font-semibold">Break-Out:</span> {{date('h:i a', strtotime($override->breakOut))}}
                    </div>
                    <div class="@if(!in_array($override->override, ['all','breakIn','breaks'])) d-none @endif"><span
                            class="font-semibold">Break-In:</span> {{date('h:i a', strtotime($override->breakIn))}}
                    </div>
                    <div class="@if(!in_array($override->override, ['all','out','inout'])) d-none @endif"><span
                            class="font-semibold">Out:</span> {{date('h:i a', strtotime($override->out))}}</div>
                </td>
                <td class="text-center">
                    @if ($override->status == 1)
                    <button type="button" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="Approve">
                        <i class="fa fa-thumbs-up text-green-500" aria-hidden="true"></i>
                    </button>
                    @elseif ($override->status == 2)
                    <button type="button" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="Decline">
                        <i class="fa fa-thumbs-down text-red-500" aria-hidden="true"></i>
                    </button>
                    @endif
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