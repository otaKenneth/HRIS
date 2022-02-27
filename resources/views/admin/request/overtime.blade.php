@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped table-inverse">
        <thead class="thead-inverse thead-dark">
            <tr>
                <th class="align-middle">
                    <i class="fa fa-filter" aria-hidden="true"></i>
                </th>
                <th colspan="5">
                    <form action="Overtime" method="get" class="d-flex">
                        <select class="custom-select mx-1" name="filter" id="fiter" style="width: 200px">
                            @foreach ($options as $key => $item)
                                <option @isset($item['selected'])
                                    @if ($item['selected'])
                                        selected
                                    @endif
                                @endisset value="{{$key}}">{{$item['value']}}</option>
                            @endforeach
                        </select>
                        <select class="selectpicker mx-1" name="employee" id="employee" data-live-search="true" title="Search ...">
                            @foreach ($employees as $key => $item)
                                <option class="dropdown-item text-dark" value="{{$key}}" @isset($item['selected'])
                                    @if ($item['selected'])
                                        selected
                                    @endif
                                @endisset>{{$item['name']}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success"><i class="fa fa-filter" aria-hidden="true"></i></button>
                        @csrf
                    </form>
                </th>
                <th>
                    <overtime-add :employees="{{$employees}}" :overtime="{{$overtime}}"></overtime-add>
                </th>
            </tr>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Date</th>
                <th>Time</th>
                <th class="text-center">Status</th>
                <th>Reason</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($overtimes as $key => $overtime)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$overtime->user->lastname}}, {{$overtime->user->firstname}} {{$overtime->user->middlename}}</td>
                    <td>{{date('M d, Y', strtotime($overtime->date))}}</td>
                    <td>{{date('h:i a', strtotime($overtime->in))}} - {{date('h:i a', strtotime($overtime->out))}}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-light" onclick="statusUp({{$key}}); function statusUp (key) {
                                $(`#status-form-${key} #status`).val('1');
                                $(`#status-form-${key}`).submit();
                            }" data-toggle="tooltip" data-placement="bottom" title="Approve">
                            <i class="fa {{($overtime->status == 1) ? 'fa-thumbs-up text-green-500':'fa-thumbs-o-up'}}" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-light" onclick="statusDown({{$key}}); function statusDown (key) {
                                $(`#status-form-${key} #status`).val('2');
                                $(`#status-form-${key}`).submit();
                            }" data-toggle="tooltip" data-placement="bottom" title="Decline">
                            <i class="fa {{($overtime->status == 2) ? 'fa-thumbs-down text-red-500':'fa-thumbs-o-down'}}" aria-hidden="true"></i>
                        </button>
                        <form id="status-form-{{$key}}" class="d-none" action="{{url("Overtime/$overtime->id/status")}}" method="post">
                            <input type="number" name="status" id="status">
                            @method('patch')
                            @csrf
                        </form>
                    </td>
                    <td>{{$overtime->reason}}</td>
                    <td>
                        <overtime-actions :overtime="{{$overtime}}" :employees="{{$employees}}"></overtime-actions>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="bg-red-300 text-center">No Results Found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>    
@endsection