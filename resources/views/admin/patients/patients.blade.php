@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped table-inverse">
            <thead class="thead-inverse thead-dark">
                <tr>
                    <th class="align-middle">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                    </th>
                    <th>
                        <form id="patient-form" action="{{url("/Patients")}}" method="get" class="d-flex">
                            <select class="selectpicker w-100 mx-1" name="search" id="search" data-live-search="true" title="Patient Name ..."
                                onchange="sendForm(); function sendForm() {
                                   $('#patient-form').submit();
                                }">
                                @foreach ($searches as $search)
                                    <option class="dropdown-item text-dark" value="{{$search->id}}">{{$search->name}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success"><i class="fa fa-filter" aria-hidden="true"></i></button>
                        </form>
                    </th>
                    <th colspan="3" class="text-end">
                        <a href=" {{url('/Patient/Create')}} " type="button" class="btn btn-primary text-light" data-toggle="tooltip" data-placement="bottom" title="Add New Patient">
                            <i class="fa fa-user-injured"></i>
                            <i class="fa fa-plus text-xs"></i>
                        </a>
                        <a href="{{url("/Patient/Export/$ids")}}" class="btn" style="background-color: #ed8936;" data-toggle="tooltip" data-placement="bottom" title="Export">
                            <i class="fa fa-file-export text-light"></i>
                        </a>
                        <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Import" onclick="upload(); function upload() { $('form#import #import-file').click(); }"><i class="fa fa-file-import"></i></button>
                        <form action="/Patient/Import" method="post" id="import" class="d-none" enctype="multipart/form-data">
                            <input type="file" name="file" id="import-file" accept=".csv,.xlsx" onchange="importSubmit(); function importSubmit() { $('form#import').submit(); }" files="">
                            @csrf
                        </form>
                    </th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Contact Info</th>
                    <th>Last Visit</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $key => $patient)
                        <tr>
                            <td> {{$key+1}} </td>
                            <td>
                                <div>{{$patient['firstname']}} {{$patient['middlename']}} {{$patient['lastname']}}</div>
                                <div class="text-xs"> {{$patient['age']}} yrs old - {{$patient['gen']['value']}} </div>
                            </td>
                            <td>
                                <div>{{$patient['email']}}</div>
                                <div class="text-xs">{{$patient['pnum']}}</div>
                            </td>
                            <td> {{date('M d, Y', strtotime($patient['updated_at']))}} </td>
                            <td>
                                <a href=" {{ url("Patient/$patient->id/Edit") }} " class="btn btn-warning"><i class="fas fa-edit text-dark"></i></a>
                                {{-- <button type="button" class="btn btn-primary"><i class="fas fa-edit"></i></button> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No Results Found.</td>
                        </tr>
                    @endforelse
                </tbody>
        </table>
    </div>
@endsection