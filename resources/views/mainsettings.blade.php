@extends('layouts.app')

@section('content')
<div class="container mx-0 pt-0">
    <div class="col-md-9 col-sm-12">
        <h3>Main Settings</h3>
    </div>
    <div class="col-md-3 col-sm-12">
        @foreach ($navigations as $nav)
            <div>{{$nav->name}}</div>
        @endforeach
    </div>
</div>
@endsection
