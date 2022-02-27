@extends('layouts.app')

@section('content')
<div class="container">
    <div class="">
        {{-- <masterlist-view :items="{{$users}}"></masterlist-view> --}}
        <table class="table table-striped table-inverse">
            <thead class="thead-inverse thead-dark">
                <tr>
                    <th colspan="3">
                        <form action="/Employee" method="get" class="row m-0">
                            <select name="search_key" id="search_key" class="custom-select col-3 py-1 px-2 mr-2">
                                @foreach ($options as $key => $opt)
                                <option @isset($opt['selected']) @if ($opt['selected']) selected @endif @endisset value="{{$key}}">{{$opt['value']}}
                                </option>
                                @endforeach
                            </select>
                            <input type="text" name="search" id="search" class="form-control col-7 mr-2" placeholder="Search">
                            <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Filter"><i class="fa fa-filter"></i></button>
                            @csrf
                        </form>
                    </th>
                    <th colspan="3" class="text-end">
                        <a href=" {{url('/Employee/Create')}} " type="button" class="btn btn-primary text-light" data-toggle="tooltip"
                            data-placement="bottom" title="Add New Employee"><i class="fa fa-user-plus"></i></a>
                        <a href="{{url("/Employee/Export/$ids")}}" type="button" class="btn" style="background-color: #ed8936;"
                            data-toggle="tooltip" data-placement="bottom" title="Export"><i class="fa fa-file-export text-light"></i></a>
                        <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Import" onclick="upload(); function upload() { $('form#import #import-file').click(); }"><i class="fa fa-file-import"></i></button>
                        <form action="/Employee/Import" method="post" id="import" class="d-none" enctype="multipart/form-data">
                            <input type="file" name="file" id="import-file" accept=".csv,.xlsx" onchange="importSubmit(); function importSubmit() { $('form#import').submit(); }" files="">
                            @csrf
                        </form>
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Print"><i class="fa fa-print"></i></button>
                    </th>
                </tr>
                <tr>
                    <th class="text-center">#</th>
                    <th>Basic Info</th>
                    <th>Contact Info</th>
                    <th>Job Info</th>
                    <th>Employment Status</th>
                    <th class="text-center"><i class="fa fa-cog"></i> Action</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($users as $key => $user)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>
                            <div>{{$user->firstname}} {{substr($user->middlename, 0,1)}}. {{$user->lastname}}</div>
                            <div class="text-xs">{{$user->username}} - {{$user->user_level->value}}</div>
                        </td>
                        <td>
                            <div>{{$user->email}}</div>
                            <div class="text-xs">{{$user->mnum}}</div>
                        </td>
                        <td>
                            <div>{{$user->employee_id}}</div>
                            <div class="text-xs">{{$user->status->value}} - {{$user->position->value}}</div>
                        </td>
                        <td>
                            <div>{{['Employed','Resigned'][$user->emp_status]}} - {{date('M d, Y', strtotime($user->hire_date))}}</div>
                            <div class="text-xs">{{($user->reg_start) ? 'Regular' : ($user->probi_start) ? 'Probationary' : 'Trainee'}}</div>
                        </td>
                        <td class="d-flex justify-content-around">
                            <a href="{{url("Employee/$user->id/Edit")}}" class="btn btn-warning text-xs text-dark" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-user-edit"></i></a>
                            {{-- <a href="" class="btn text-xs text-dark" style="background-color: #90cdf4;" data-placement="bottom" title="View"><i class="fa fa-eye"></i></a> --}}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center bg-red-300" colspan="6">No Results Found.</td>
                    </tr>
                    @endforelse
                </tbody>
        </table>
    </div>
</div>
@endsection
