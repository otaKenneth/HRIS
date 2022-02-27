@extends('layouts.app')

@section('content')
<div id="employee-profile" class="container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="main-tab" data-toggle="tab" href="#main" role="tab" aria-controls="main"
                aria-selected="true">Main</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                aria-selected="false">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="wss-tab" data-toggle="tab" href="#wss" role="tab" aria-controls="wss"
                aria-selected="false">Weekly Schedule & Salary</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="security-tab" data-toggle="tab" href="#security" role="tab" aria-controls="security"
                aria-selected="false">Security</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active m-3" id="main" role="tabpanel" aria-labelledby="main-tab">
            <create-employee :employee="{{$user}}" :heads="{{$heads}}"></create-employee>
        </div>
        <div class="tab-pane fade m-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            Profile ..
        </div>
        <div class="tab-pane fade m-3" id="wss" role="tabpanel" aria-labelledby="wss-tab">
            @if ($salary !== null)
                <div id="salary">
                    <h3>Salary</h3>
                    <div class="row">
                        <div class="col-2">
                            <label for="" class="font-semibold text-xs">Per Minute Rate</label>
                            <div>Php {{number_format($salary->per_min, 2)}}</div>
                        </div>
                        <div class="col-2">
                            <label for="" class="font-semibold text-xs">Hourly Rate</label>
                            <div>Php {{number_format($salary->hourly, 2)}}</div>
                        </div>
                        <div class="col-2">
                            <label for="" class="font-semibold text-xs">Daily Rate</label>
                            <div>Php {{number_format($salary->daily, 2)}}</div>
                        </div>
                        <div class="col-2">
                            <label for="" class="font-semibold text-xs">Monthly Rate</label>
                            <div>Php {{number_format($salary->monthly, 2)}}</div>
                        </div>
                        <div class="col-2">
                            <label for="" class="font-semibold text-xs">Allowance Type</label>
                            <div>{{$salary->allowance_type}}</div>
                        </div>
                        <div class="col-2">
                            <label for="" class="font-semibold text-xs">Allowance</label>
                            <div>Php {{number_format($salary->allowance, 2)}}</div>
                        </div>
                    </div>
                </div>
            @else
                <h3>No Given Salary Yet.</h3>
            @endif
            @if (count($events) > 0)
                <weekly-calendar :events="{{json_encode($events)}}"></weekly-calendar>
            @else
                <h3>No Given Schedule Yet.</h3>
            @endif
        </div>
        <div class="tab-pane fade m-3" id="security" role="tabpanel" aria-labelledby="security-tab">
            <form action="/201File/{{$user->id}}/update_password" method="post" class="form-group">
                <div class="form-group col-4 m-0">
                    <label for="old_password">Password</label>
                    <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" id="old_password" autofocus>
                    @error('old_password')
                        <small id="helpId" class="invalid-feedback">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group col-4 m-0">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                    @error('password')
                        <small id="helpId" class="invalid-feedback">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group col-4 m-0">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                    @error('password_confirmation')
                        <small id="helpId" class="invalid-feedback">Password didn't matched.</small>
                    @enderror
                </div>
                @csrf
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection