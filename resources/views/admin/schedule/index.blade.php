@extends('layouts.app')

@section('content')
<schedule-list :items="{{$users}}"></schedule-list>
@endsection