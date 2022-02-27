@extends('layouts.app')

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="container container-fluid">
    <form action="{{url("Patient")}}" method="post">
        @csrf
        <div class="row m-0">
            <div class="col-12 col-md-6 m-0">
                <span class="font-semibold">Patient Name:</span>
                <div class="row">
                    <div class="form-group col-12 col-md-4 m-0">
                        <label for="firstname">First Name: </label>
                        <input type="text" name="firstname" id="firstname"
                            class="form-control @error('firstname') is-invalid @enderror" placeholder="Aa..."
                            value="{{$patient['firstname']}}" autofocus>
                        @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-4 m-0">
                        <label for="middlename">Middle Name: </label>
                        <input type="text" name="middlename" id="middlename"
                            class="form-control @error('middlename') is-invalid @enderror" placeholder="Aa..."
                            value="{{$patient['middlename']}}">
                        @error('middlename')
                        <span class="invalid-feedback" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-4 m-0">
                        <label for="lastname">Last Name: </label>
                        <input type="text" name="lastname" id="lastname"
                            class="form-control @error('lastname') is-invalid @enderror" placeholder="Aa..."
                            value="{{$patient['lastname']}}">
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
                        <input type="text" name="age" id="age" class="form-control @error('age') is-invalid @enderror"
                            placeholder="Aa..." value="{{$patient['age']}}" autofocus onkeypress="return event.key >= '0' && event.key <= '9'" maxlength="2">
                        @error('age')
                        <span class="invalid-feedback" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-4 m-0">
                        <label for="birthdate">Birthdate: </label>
                        <input type="text" name="birthdate" id="birthdate"
                            class="form-control datepicker @error('birthdate') is-invalid @enderror"
                            placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" data-provide="datepicker"
                            value="{{$patient['birthdate']}}">
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
                <address-form address="{{$patient['address']}}" town="{{$patient['town']}}"
                    province="{{$patient['province']}}" address_err="@error('address'){{$message}}@enderror"
                    town_err="@error('town'){{$message}}@enderror"
                    province_err="@error('province'){{$message}}@enderror"></address-form>
                <input type="text" name="country" id="country" value="{{$patient['country']}}" class="hidden">
                <span class="font-semibold">Contact Info:</span>
                <div class="row">
                    <div class="form-group col-12 col-md-4 m-0">
                        <label for="email">E-mail: </label>
                        <input type="text" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Aa..."
                            value="{{$patient['email']}}" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-4 m-0">
                        <label for="pnum">Phone Number: </label>
                        <input type="text" name="pnum" id="pnum"
                            class="form-control @error('pnum') is-invalid @enderror" placeholder="Aa..."
                            value="{{$patient['pnum']}}" onkeypress="return event.key >= '0' && event.key <= '9'" maxlength="11">
                        @error('pnum')
                        <span class="invalid-feedback" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-4 m-0">
                        <label for="">&nbsp;</label>
                        <input type="submit" name="submit" id="submit" class="form-control btn btn-primary"
                            value="Save">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
        </div>
    </form>
</div>
@endsection