@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card col-12">
        <h4 class="card-title px-3">Defaults</h4>
        <div class="card-body p-0">
            <form action="{{url("/Payroll/Settings")}}" method="POST">
                <div class="row m-0 p-0">
                    <div class="col-md-2 row m-0 pt-0">
                        <div class="form-group col-12 m-0 px-0">
                            <label for="from">Start Date</label>
                            <input type="number" name="defaults[from]" id="from" class="form-control w-100 @error('defaults.from')
                                is-invalid
                            @enderror" min="1" max="31" placeholder="date" value="{{$arr['payroll']['defaults']['from']}}">
                            @error('defaults.from')
                                <small id="helpId" class="text-red-500 text-xs">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group col-12 m-0 px-0">
                            <label for="every">Payroll Every</label>
                            <input type="number" name="defaults[every]" id="every" class="form-control w-100 @error('defaults.every')
                                is-invalid
                            @enderror" min="1" max="31" placeholder="day" value="{{$arr['payroll']['defaults']['every']}}">
                            @error('defaults.every')
                                <small id="helpId" class="text-red-500 text-xs">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group col-12 m-0 px-0">
                            <label for="efectivitydate">Effectivity Date</label>
                            <input type="text" name="defaults[efectivitydate]" id="efectivitydate" class="form-control w-100 datepicker @error('defaults.efectivitydate')
                                is-invalid
                            @enderror" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" value="{{$arr['payroll']['defaults']['efectivitydate']}}">
                            @error('defaults.efectivitydate')
                                <small id="helpId" class="text-red-500 text-xs">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 row m-0 pt-0">
                        <div class="form-group col-12 m-0 px-0">
                            <label for="rhunworked">RH : Unworked</label>
                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" name="rh[regular][unworked]" id="rhunworked" class="form-control" placeholder="%" value="{{$arr['payroll']['rh']['regular']['unworked']}}">
                            @error('rh.regular.unworked')
                                <small id="helpId" class="text-red-500 text-xs">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group col-12 m-0 px-0">
                            <label for="rhworked">RH : Worked</label>
                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" name="rh[regular][worked]" id="rhworked" class="form-control" placeholder="%"
                                value="{{$arr['payroll']['rh']['regular']['worked']}}">
                            @error('rh.regular.worked')
                                <small id="helpId" class="text-red-500 text-xs">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group col-12 m-0 px-0">
                            <label for="rhworkedrd">RH : Worked & RD</label>
                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" name="rh[regular][worked&rd]" id="rhworkedrd" class="form-control" placeholder="%"
                                value="{{$arr['payroll']['rh']['regular']['worked&rd']}}">
                            @error('rh.regular.worked&rd')
                                <small id="helpId" class="text-red-500 text-xs">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 row m-0 pt-0">
                        <div class="form-group col-12 m-0 px-0">
                            <label for="shunworked">SH : Unworked</label>
                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" name="sh[unworked]" id="shunworked" class="form-control" placeholder="%"
                                value="{{$arr['payroll']['sh']['unworked']}}">
                            @error('sh.unworked')
                                <small id="helpId" class="text-red-500 text-xs">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group col-12 m-0 px-0">
                            <label for="shworked">SH : Worked</label>
                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" name="sh[worked]" id="shworked" class="form-control" placeholder="%"
                                value="{{$arr['payroll']['sh']['worked']}}">
                            @error('sh.worked')
                                <small id="helpId" class="text-red-500 text-xs">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group col-12 m-0 px-0">
                            <label for="shworkedrd">SH : Worked & RD</label>
                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" name="sh[worked&rd]" id="shworkedrd" class="form-control" placeholder="%"
                                value="{{$arr['payroll']['sh']['worked&rd']}}">
                            @error('sh.worked&rd')
                                <small id="helpId" class="text-red-500 text-xs">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 row m-0 pt-0">
                        <table class="table table-striped table-inverse table-responsive">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>OT on</th>
                                    <th>Day Shift</th>
                                    <th>Night Diff</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Regular</td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.regular') is-invalid @enderror" name="ot[regular]" id="otregular" placeholder="%" value="{{$arr['payroll']['ot']['regular']}}">
                                            @error('ot.regular')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.nd.regular') is-invalid @enderror" name="ot[nd][regular]" id="otndregular" placeholder="%" value="{{$arr['payroll']['ot']['nd']['regular']}}">
                                            @error('ot.nd.regular')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rest Day</td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.restday') is-invalid @enderror" name="ot[restday]" id="otrestday" placeholder="%" value="{{$arr['payroll']['ot']['restday']}}">
                                            @error('ot.restday')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.nd.restday') is-invalid @enderror" name="ot[nd][restday]" id="otndrestday" placeholder="%" value="{{$arr['payroll']['ot']['nd']['restday']}}">
                                            @error('ot.nd.restday')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Special Holiday</td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.SH') is-invalid @enderror" name="ot[SH]" id="otSH" placeholder="%" value="{{$arr['payroll']['ot']['SH']}}">
                                            @error('ot.SH')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.nd.SH') is-invalid @enderror" name="ot[nd][SH]" id="otndSH" placeholder="%" value="{{$arr['payroll']['ot']['nd']['SH']}}">
                                            @error('ot.nd.SH')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Special Holiday & RD</td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.SH&rd') is-invalid @enderror" name="ot[SH&rd]" id="otSH&rd" placeholder="%" value="{{$arr['payroll']['ot']['SH&rd']}}">
                                            @error('ot.SH&rd')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.nd.SH&rd') is-invalid @enderror" name="ot[nd][SH&rd]" id="otndSH&rd" placeholder="%" value="{{$arr['payroll']['ot']['nd']['SH&rd']}}">
                                            @error('ot.nd.SH&rd')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Regular Holiday</td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.RH') is-invalid @enderror" name="ot[RH]" id="otRH" placeholder="%" value="{{$arr['payroll']['ot']['RH']}}">
                                            @error('ot.RH')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.nd.RH') is-invalid @enderror" name="ot[nd][RH]" id="otndRH" placeholder="%" value="{{$arr['payroll']['ot']['nd']['RH']}}">
                                            @error('ot.nd.RH')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Regular Holiday & RD</td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.RH&rd') is-invalid @enderror" name="ot[RH&rd]" id="otRH&rd" placeholder="%" value="{{$arr['payroll']['ot']['RH&rd']}}">
                                            @error('ot.RH&rd')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input onkeypress="return (event.key >= '0' && event.key <= '9') || event.key =='%' || event.key == '.'" type="text" class="form-control @error('ot.nd.RH&rd') is-invalid @enderror" name="ot[nd][RH&rd]" id="otndRH&rd" placeholder="%" value="{{$arr['payroll']['ot']['nd']['RH&rd']}}">
                                            @error('ot.nd.RH&rd')
                                                <small id="helpId" class="form-text text-red-500 text-xs">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @csrf
                @method('patch')
                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection