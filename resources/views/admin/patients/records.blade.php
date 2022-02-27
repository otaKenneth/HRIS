@extends('layouts.app')

@section('content')
    <div class="container container-fluid">
        <form action="{{url("Patient/$patient->id")}}" method="post">
            @csrf
            @method('patch')
            <div class="row m-0">
                <div class="col-12 col-md-6 m-0">
                    <span class="font-semibold">Patient Name:</span>
                    <div class="row">
                        <div class="form-group col-12 col-md-4 m-0">
                            <label for="firstname">First Name: </label>
                            <input type="text" name="firstname" id="firstname" class="form-control @error('firstname') is-invalid @enderror" placeholder="Aa..." value="{{$patient['firstname']}}" autofocus>
                            @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-4 m-0">
                            <label for="middlename">Middle Name: </label>
                            <input type="text" name="middlename" id="middlename" class="form-control @error('middlename') is-invalid @enderror" placeholder="Aa..." value="{{$patient['middlename']}}">
                            @error('middlename')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-4 m-0">
                            <label for="lastname">Last Name: </label>
                            <input type="text" name="lastname" id="lastname" class="form-control @error('lastname') is-invalid @enderror" placeholder="Aa..." value="{{$patient['lastname']}}">
                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <span class="font-semibold">Other Info:</span>
                    <div class="row">
                        <div class="form-group col-12 col-md-4 m-0">
                            <label for="age">Age: </label>
                            <input type="text" name="age" id="age" class="form-control @error('age') is-invalid @enderror" placeholder="Aa..." value="{{$patient['age']}}" autofocus>
                            @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-4 m-0">
                            <label for="birthdate">Birthdate: </label>
                            <input type="text" name="birthdate" id="birthdate" class="form-control datepicker @error('birthdate') is-invalid @enderror" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" data-provide="datepicker" value="{{$patient['birthdate']}}">
                            @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 m-0">
                            <label for="gender">Gender: </label>
                            <lk-select id="gender" value="{{$patient['gender']}}"></lk-select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 m-0">
                    <span class="font-semibold">Address:</span>
                    <address-form address="{{$patient['address']}}" town="{{$patient['town']}}" province="{{$patient['province']}}" address_err="@error('address'){{$message}}@enderror" town_err="@error('town'){{$message}}@enderror" province_err="@error('province'){{$message}}@enderror"></address-form>
                    <span class="font-semibold">Contact Info:</span>
                    <div class="row">
                        <div class="form-group col-12 col-md-4 m-0">
                            <label for="email">E-mail: </label>
                            <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Aa..." value="{{$patient['email']}}" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-4 m-0">
                            <label for="pnum">Phone Number: </label>
                            <input type="text" name="pnum" id="pnum" class="form-control @error('pnum') is-invalid @enderror" placeholder="Aa..." value="{{$patient['pnum']}}">
                            @error('pnum')
                                <span class="invalid-feedback" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-4 m-0">
                          <label for="">&nbsp;</label>
                          <input type="submit" name="submit" id="submit" class="form-control btn btn-primary" value="Save">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
            </div>
        </form>
        <div class="mx-4">
            <table class="table table-striped table-inverse table-responsive-sm">
                <thead class="thead-inverse thead-dark">
                    <tr>
                        <th>#</th>
                        <th>General Survey</th>
                        <th>Vitals</th>
                        <th>Chief Complaint</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th><i class="fa fa-cog"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $key => $record)
                            <tr>
                                <td> {{$key+1}} </td>
                                <td> {{$record['gen_survey']}} </td>
                                <td>
                                    <div> {{$record['bp']}} - {{$record['hr']}} - {{$record['rr']}} </div>
                                    <div> {{$record['weight']}} kg - {{$record['temp']}} °C </div>
                                </td>
                                <td> {{$record['chief_complaint']}} </td>
                                <td> Php {{number_format($record['payment'], 2)}} </td>
                                <td> {{date('M d, Y', strtotime($record['created_at']))}} </td>
                                <td>
                                    <a href="{{url("Patient/$patient->id/Record/$record->id/Edit")}}" class="btn btn-warning text-dark"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="bg-red-300 text-center">No Records Found.
                                    <a href=" {{url("/Patient/$patient->id/Record/Create")}} " type="button" class="btn btn-primary text-light" data-toggle="tooltip" data-placement="bottom" title="Add New Patient">
                                        <i class="fa fa-user-injured"></i>
                                        <i class="fa fa-plus text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
            </table>
        </div>
    </div>
@endsection