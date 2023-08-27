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
                <span class="user-role text-primary">{{ Auth::user()->job_position }}</span>
                <span class="user-status text-primary">
                    <i class="fa fa-circle"></i>
                    <span>Online</span>
                </span>
            </div>
        </a>
    </div>
    <div class="sidebar-menu">
        <ul>
            @foreach (Auth::user()->navigations as $mains)
                @if ($mains->visible)
                    <li class="header-menu">
                        <span>{{$mains->name}}</span>
                    </li>
                    @foreach ($mains->sub_navigations as $sub_navs)
                        @if ($sub_navs->href === "#")
                            <li class="sidebar-dropdown">
                                <a href="{{ url($sub_navs->href) }}">
                                    <i class="{{$sub_navs->icon}}"></i>
                                    <span>{{$sub_navs->name}}</span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        @foreach ($sub_navs->sub_lvl_navigations as $sub_lvl_nav)
                                            <li>
                                                <a href="{{ url($sub_lvl_nav->href) }}">{{$sub_lvl_nav->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @else
                            <li class="">
                                <a href="{{ url($sub_navs->href) }}">
                                    <i class="{{ $sub_navs->icon }}"></i>
                                    <span>{{$sub_navs->name}}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
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
    <a href="/Settings">
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