@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped table-inverse">
        <thead class="thead-inverse thead-dark">
            <tr>
                <th></th>
                <th colspan="5">
                    <form action="{{url("Shift")}}" method="get">
                        <input type="text" class="form-control" name="search" id="search" aria-describedby="helpId" placeholder="Search Code/Time">
                        <button type="submit" class="btn btn-primary d-none"></button>
                    </form>
                </th>
                <th class="text-center">
                    <shift-add-button></shift-add-button>
                </th>
            </tr>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>In</th>
                <th>Break-Out</th>
                <th>Break-In</th>
                <th>Out</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($shifts as $key => $shift)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>
                            {{$shift['code']}}
                            {{-- <div class="text-wrap">
                            </div> --}}
                        </td>
                        @if ($shift['opentime'])
                            <td colspan="4" class="text-center">Flexible Time</td>
                        @elseif ($shift['code'] == "off")
                            <td colspan="4" class="text-center">Rest Day</td>
                        @else
                            <td>{{date('h:i a', strtotime($shift['in']))}}</td>
                            @if ($shift['breaks'])
                                <td>{{ ($shift['breakOut'] == null) ? '-':date('h:i a', strtotime($shift['breakOut']))}}</td>
                                <td>{{ ($shift['breakIn'] == null) ? '-':date('h:i a', strtotime($shift['breakIn']))}}</td>
                            @else
                                <td colspan="2" class="text-center">Flexible Break</td>
                            @endif
                            <td>{{date('h:i a', strtotime($shift['out']))}}</td>
                        @endif
                        <td>
                            <shift-edit-button :shift="{{$shift}}"></shift-edit-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="bg-red-300 text-center">No Results Found.</td>
                    </tr>
                @endforelse
            </tbody>
    </table>
</div>
@endsection