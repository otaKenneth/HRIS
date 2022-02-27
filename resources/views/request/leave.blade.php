@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped table-inverse">
        <thead class="thead-inverse thead-dark">
            <tr>
                <th class="align-middle">
                    <i class="fa fa-filter" aria-hidden="true"></i>
                </th>
                <th colspan="3">
                    <form id="leave-form" action="/Leave/{{Auth::user()->id}}" method="get">
                        {{-- <span class="m-2">{{Arr::get($employees, 'emps.*.selected')}}</span> --}}
                        <select class="selectpicker" name="filter">
                            @foreach ($options as $key => $value)
                            <option class="dropdown-item text-dark" value="{{$key}}" @isset($value['selected']) @if ($value['selected']) selected @endif @endisset>{{$value['value']}}</option>
                            @endforeach
                        </select>
                        {{-- <input type="text" name="search" id="search" class="form-control" placeholder="Search ..." aria-describedby="helpId" value="{{$request->search}}">
                        --}}
                        <button type="submit" id="submit" class="btn btn-success"><i class="fa fa-filter" aria-hidden="true"></i></button>
                        @csrf
                    </form>
                </th>
                <th colspan="3" class="align-middle"></th>
                <th class="text-center">
                    <leave-add :employees="{{$employees}}" :leave="{{$leave}}"></leave-add>
                </th>
            </tr>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Type</th>
                <th>Date Range</th>
                <th>Reason</th>
                <th class="text-center">Status</th>
                <th>Updated At</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($leaves as $key => $leave)
            <tr>
                <td>{{$key+1}}</td>
                <td>You</td>
                <td>{{$leave->type}}</td>
                <td>{{date('M d, Y', strtotime($leave->from))}} - {{date('M d, Y', strtotime($leave->to))}}</td>
                <td>{{$leave->reason}}</td>
                <td class="text-center">
                    @if ($leave->status == 1)
                    <button type="button" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="Approved">
                        <i class="fa {{($leave->status == 1) ? 'fa-thumbs-up text-green-500':'fa-thumbs-o-up'}}"
                            aria-hidden="true"></i>
                    </button>
                    @elseif ($leave->status == 2)
                    <button type="button" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="Declined">
                        <i class="fa {{($leave->status == 2) ? 'fa-thumbs-down text-red-500':'fa-thumbs-o-down'}}"
                            aria-hidden="true"></i>
                    </button>
                    @endif
                </td>
                <td>{{date('M d, Y', strtotime($leave->created_at))}}</td>
                <td>
                    <leave-actions :leave="{{$leave}}" :employees="{{$employees}}"></leave-actions>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="bg-red-300 text-center">No Results Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection