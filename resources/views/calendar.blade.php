@extends('layouts.app')

@section('content')
<div class="container py-0">
    <calendar :events="{{$events}}"></calendar>
</div>
@endsection