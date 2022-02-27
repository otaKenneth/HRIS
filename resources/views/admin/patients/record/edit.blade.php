@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between">
        <h3> Record of {{$patient->firstname}} at @if ($editable)
            {{date('M d, Y', strtotime($record->created_at))}}
            @else
            {{date('M d, Y')}}
        @endif </h3>
        <a href="{{url("Patient/$patient->id/Edit")}}" class="btn btn-danger text-light"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
    </div>
    <patient-record :patient="{{$patient}}" :record="{{$record}}" e="{{$editable}}"></patient-record>
</div>
@endsection