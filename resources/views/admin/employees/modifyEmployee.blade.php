@extends('layouts.app')

@section('content')
<div id="modify-employee" class="container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="main-tab" data-toggle="tab" href="#main" role="tab" aria-controls="main" aria-selected="true">Main</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active m-3" id="main" role="tabpanel" aria-labelledby="main-tab">
            <create-employee :employee="{{$user}}" :heads="{{$heads}}"></create-employee>
        </div>
        <div class="tab-pane fade m-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            Profile ..
        </div>
    </div>
</div>
@endsection