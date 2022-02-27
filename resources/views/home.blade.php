@extends('layouts.app')

@section('content')
<div class="container row mx-0 pt-0">
    <div class="col-md-9 col-sm-12">
        <h3>{{$m_date}}</h3>
        <patients userlvl="{{Auth::user()->admin}}"></patients>
    </div>
    <div class="col-md-3 col-sm-12">
        <datepick-component></datepick-component>
    </div>
</div>
@endsection
