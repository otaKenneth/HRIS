@extends('layouts.app')

@section('content')
<div class="container container-fluid">
    <div class="col-md-9 col-sm-12">
        <h3><a href="/Settings">Main Settings</a> / User Navigations</h3>
    </div>
    <div class="container w-100">
        <table class="table table-striped table-inverse">
            <thead class="thead-inverse">
                <tr>
                    <th style="width: 50px;">Icon</th>
                    <th>Name</th>
                    <th>HREF</th>
                    <th style="width: 100px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($main_navs as $nav)
                    <tr>
                        <td scope="row">{{$nav->icon}}</td>
                        <td>{{$nav->name}}</td>
                        <td>{{$nav->href}}</td>
                        <td>
                            <div class="d-flex justify-content-center align-center">
                                <a href="{{url("/Settings/User-Nav-Connections/$nav->name")}}">
                                    <button type="button" class="btn btn-primary btn-sm btn-block m-0 mr-2">
                                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                    </button>
                                </a>
                                <button type="button" class="btn btn-warning btn-sm btn-block m-0 mr-2">
                                <i class="fa fa-pencil-square" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-danger btn-sm btn-block m-0">
                                <i class="fa fa-trash-o" aria-hidden="true"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</div>
@endsection