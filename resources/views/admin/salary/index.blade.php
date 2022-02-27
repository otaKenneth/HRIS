@extends('layouts.app')

@section('content')
<div id="salary" class="container">
    <table class="table table-striped table-inverse">
        <thead class="thead-inverse thead-dark">
            <tr>
                <th class="text-center align-middle">-</th>
                <th colspan="2">
                    <form action="" method="get">
                        <div class="row mx-2">
                            <div class="form-group m-0 my-1">
                                <select class="form-control" name="operator" id="operator">
                                    <option value="all">All</option>
                                    <option value="=">=</option>
                                    <option value=">">></option>
                                    <option value=">=">>=</option>
                                    <option value="<"><</option>
                                    <option value="<="><=</option>
                                    <option value="<>"><></option>
                                    <option value="between">><</option>
                                </select>
                            </div>
                            <div class="form-group mx-2 my-1">
                                <input type="text" class="form-control" name="search" id="search" aria-describedby="helpId" placeholder="Salary Search...">
                            </div>
                            <div class="form-group mx-2 my-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-filter"></i></button>
                            </div>
                        </div>
                        <div class="text-xs text-blue-400"><i class="fas fa-exclamation-circle"></i> Seperate with coma if you choose between operator.</div>
                    </form>
                </th>
                <th colspan="4"></th>
            </tr>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Job Info</th>
                <th>Employment Status</th>
                <th class="text-center">Salary</th>
                <th class="text-center">Allowance</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $key => $item)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$item['lastname']}}, {{$item['firstname']}} <br> {{$item['middlename']}}</td>
                <td>
                    <div>{{$item->employee_id}}</div>
                    <div class="text-xs">{{$item->status->value}} - {{$item->position->value}}</div>
                </td>
                <td>
                    <div>{{['Employed','Resigned'][$item->emp_status]}} - {{date('M d, Y', strtotime($item->hire_date))}}</div>
                    <div class="text-xs">
                    @if ($item->training_start)
                        @if ($item->probi_start)
                            @if ($item->reg_start)
                                Regular
                            @else
                                Probationary
                            @endif
                        @else
                            Trainee
                        @endif
                    @endif
                    </div>
                </td>
                <td class="text-center">
                    @if (isset($item['salary']['monthly']))
                        <div>Php {{number_format($item['salary']['monthly'], 2)}}</div>
                        <v-divider class="m-0"></v-divider>
                        <div class="text-xs"><span class="text-blue-600">{{$item['salary']['tndp']}}</span> - Php {{number_format($item['salary']['daily'], 2)}}</div>
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">
                    @if (isset($item['salary']['allowance']))
                        <div class="text-xs"><span class="text-blue-600">{{$item['salary']['allowance_type']}}</span></div>
                        <v-divider class="m-0"></v-divider>
                        <div>Php {{number_format($item['salary']['allowance'], 2)}}</div>
                    @else
                        -
                    @endif
                </td>
                @if ($item['salary'] !== null)
                <td>
                    <salary-actions :salary="{{$item->salary}}" employee="{{$item->lastname . ', ' . $item->firstname . ' ' . $item->middlename}}"></salary-actions>
                </td>
                @else
                <td>
                    <salary-actions :salary="{{json_encode(['user_id' => $item->id, 'tndp' => 313, 'salary_type' => 'monthly', 'allowance_type' => 'daily'])}}" employee="{{$item->lastname . ', ' . $item->firstname . ' ' . $item->middlename}}"></salary-actions>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td class="bg-red-300 text-center" colspan="7">No Results Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection