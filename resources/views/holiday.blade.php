@extends('layouts.app')

@section('content')
<div class="container">
    <div style="height: 90vh; overflow: auto;">
        <table class="table table-striped table-inverse">
            <thead class="thead-inverse thead-dark thead-sticky">
                <tr>
                    <th class="align-middle"><i class="fa fa-filter" aria-hidden="true"></i></th>
                    <th colspan="2">
                        <form action="/Holiday" method="get" class="d-flex">
                            <select class="custom-select mx-1" name="filter" id="filter" style="width: 200px">
                                @foreach ($options as $key => $item)
                                    <option value="{{$key}}" @isset($item['selected'])
                                        @if ($item['selected'])
                                            selected
                                        @endif
                                    @endisset>{{$item['value']}}</option>                                
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success"><i class="fa fa-filter" aria-hidden="true"></i></button>
                        </form>
                    </th>
                    <th></th>
                    <th class="text-center">
                        <holiday-add></holiday-add>
                    </th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($holidays as $key => $holiday)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$holiday->title}}</td>
                        <td>{{$holiday->type}}</td>
                        @if ($holiday->from == $holiday->to)
                            <td>{{date('M d, Y', strtotime($holiday->from))}}</td>
                        @else
                            <td>{{date('M d, Y', strtotime($holiday->from))}} - {{date('M d, Y', strtotime($holiday->to))}}</td>
                        @endif
                        <td class="text-center">
                            <holiday-actions :holiday="{{$holiday}}"></holiday-actions>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="bg-red-300 text-center">No Results Found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection