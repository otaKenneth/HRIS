<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sidenav.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    @if(Auth::user())
        <v-app id="app">
            <div class="row">
                <button type="button" id="sidebar-toggler" class="d-block d-sm-none btn btn-default bg-dark"><i class="fas fa-arrow-right text-light"></i></button>
                <nav id="sidebar" class="d-none d-sm-block col-sm-3 col-md-2 sidebar-wrapper">
                    @include('partials.sidenav')
                </nav>
                <main id="page-content" class="col-md-10 col-sm-9">
                    @yield('content')
                </main>
            </div>
        </v-app>
    @else
        <main class="py-4">
            @yield('content')
        </main>
    @endif
    </div>
</body>

</html>