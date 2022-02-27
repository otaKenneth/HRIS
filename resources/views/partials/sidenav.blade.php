<link href="{{ asset('css/sidenav.css') }}" rel="stylesheet">
<div class="sidebar-content">
    <div class="sidebar-brand">
        <a href="#">{{ config('app.name', 'Laravel') }}</a>
        <div id="close-sidebar">
            <i class="fas fa-times"></i>
        </div>
    </div>
    <div class="sidebar-header">
        <a href="#">
            <div class="user-pic">
                <img class="img-responsive img-rounded" src="@if (Auth::user()->profile !== null)
                    /storage/{{Auth::user()->profile}}
                @endif" alt="User picture">
            </div>
            <div class="user-info">
                <a class="user-name" href="{{ url('/201File/' . Auth::user()->id) }}">
                    <strong>{{ Auth::user()->username }}</strong>
                </a>
                <span class="user-role text-primary">{{ Auth::user()->position->value }}</span>
                <span class="user-status text-primary">
                    <i class="fa fa-circle"></i>
                    <span>Online</span>
                </span>
            </div>
        </a>
    </div>
    <div class="sidebar-menu">
        <ul>
            <li class="header-menu">
                <span>General</span>
            </li>
            <li class="">
                <a href="{{ url('home') }}">
                    <i class="fa fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{url('Calendar')}}">
                    <i class="fa fa-calendar"></i>
                    <span>Calendar</span>
                </a>
            </li>
            @can ('viewAny', Auth::user())
            <li class="sidebar-dropdown">
                <a href="#">
                    <i class="fa fa-user-injured"></i>
                    <span>Patients</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li>
                            <a href="{{ url('Patients') }}">List</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="#">
                    <i class="fas fa-user-tie"></i>
                    <span>Employee</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li>
                            <a href="{{ url('Employees') }}">List</a>
                        </li>
                        <li>
                            <a href="{{ url('Schedule') }}">Schedule</a>
                        </li>
                        <li>
                            <a href="{{ url('Salary') }}">Salary</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            <li class="header-menu">
                <span>Timekeep</span>
            </li>
            @can ('viewAny', Auth::user())
            <li>
                <a href="{{ url('Shift') }}">
                    <i class="fa fa-business-time"></i>
                    <span>Shift</span>
                </a>
            </li>
            @endcan
            <li>
                @can ('viewAny', Auth::user())
                    <a href="{{ url('DTR') }}">
                        <i class="fa fa-user-clock" aria-hidden="true"></i>
                        <span>Daily Time Record</span>
                    </a>
                @endcan
                @cannot('viewAny', Auth::user())
                    <a href="{{ url('DTR/' . Auth::user()->id) }}">
                        <i class="fa fa-user-clock" aria-hidden="true"></i>
                        <span>Daily Time Record</span>
                    </a>
                @endcannot
            </li>
            <li class="sidebar-dropdown">
                <a href="#">
                    <i class="fa fa-file-o" aria-hidden="true"></i>
                    <span>Request</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        @can('viewAny', Auth::user())
                        <li>
                            <a href="{{ url("Leave/") }}">Leave</a>
                        </li>
                        {{-- <li>
                            <a href="{{ url('OfficialBusiness') }}" data-toggle="tooltip" data-placement="left" title="Official Business">OB</a>
                        </li> --}}
                        <li>
                            <a href="{{ url('Override') }}">Override</a>
                        </li>
                        <li>
                            <a href="{{ url('Overtime') }}">Overtime</a>
                        </li>
                        @endcan
                        @cannot('viewAny', Auth::user())
                        <li>
                            <a href="{{ url("Leave/" . Auth::user()->id) }}">Leave</a>
                        </li>
                        <li>
                            <a href="{{ url("Override/" . Auth::user()->id) }}">Override</a>
                        </li>
                        <li>
                            <a href="{{ url("Overtime/" . Auth::user()->id) }}">Overtime</a>
                        </li>
                        @endcannot
                    </ul>
                </div>
            </li>
            @can('viewAny', Auth::user())
            <li class="header-menu">
                <span>Payroll</span>
            </li>
            <li>
                <a href="{{url("Payroll/Computation")}}">
                    <i class="fa fa-calculator"></i>
                    <span>Computation</span>
                </a>
                <a href="{{url("Payroll/PaySlip")}}">
                    <i class="fa fa-file-alt"></i>
                    <span>Pay Slip</span>
                </a>
                <a href="{{url("Payroll/Settings")}}">
                    <i class="fa fa-cogs"></i>
                    <span>Settings</span>
                </a>
            </li>
            @endcan
            {{-- <li class="sidebar-dropdown">
                <a href="#">
                    <i class="fa fa-chart-line"></i>
                    <span>Charts</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li>
                            <a href="#">Pie chart</a>
                        </li>
                        <li>
                            <a href="#">Line chart</a>
                        </li>
                        <li>
                            <a href="#">Bar chart</a>
                        </li>
                        <li>
                            <a href="#">Histogram</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            <li class="header-menu">
                <span>Extra</span>
            </li>
            @can('viewAny', Auth::user())
            <li>
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li>
                <a href="{{ url('Holiday') }}">
                    <i class="fa fa-calendar-day"></i>
                    <span>Holiday</span>
                </a>
            </li>
            <li>
                <a href=" {{url('Lookup')}} ">
                    <i class="fa fa-folder"></i>
                    <span>Look-up</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
    <!-- sidebar-menu  -->
</div>
<!-- sidebar-content  -->
<div class="sidebar-footer">
    <notif-bell user="{{Auth::user()->id}}" :unreads="{{auth()->user()->unreadNotifications()->orderBy('updated_at')->get()}}"></notif-bell>
    <a href="#">
        <i class="fa fa-envelope"></i>
        {{-- <span class="badge badge-pill badge-success notification">0</span> --}}
    </a>
    <a href="#">
        <i class="fa fa-cog"></i>
        {{-- <span class="badge-sonar"></span> --}}
    </a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-power-off"></i>
    </a>
    <form id="logout-form" action="/logout" method="POST" style="display: none;">
        @csrf
    </form>
</div>