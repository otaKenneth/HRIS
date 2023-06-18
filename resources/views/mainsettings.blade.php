@extends('layouts.app')

@section('content')
<div class="container container-fluid">
    <div class="col-md-9 col-sm-12">
        <h3>Main Settings</h3>
    </div>
    <div class="row col-md-3 col-sm-12 ">
        @foreach ($navigations as $nav)
            <a class="py-3 px-1 d-flex align-center" href="{{ url($nav->href) }}">
                <i class="{{$nav->icon}} mr-2"></i>
                <div>{{$nav->name}}</div>
            </a>
        @endforeach
    </div>
</div>
@endsection
