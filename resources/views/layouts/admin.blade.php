<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name', 'Laravel')}}</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="{{ env("ADMIN_URL").'/dist/daterangepicker.css' }}" rel="stylesheet">
    <link href="{{ env("ADMIN_URL").'/vendor/font-awesome/css/all.min.css' }}" rel="stylesheet">
    <link href="{{ env("ADMIN_URL").'/css/admin.css' }}" rel="stylesheet">
    <link href="{{ env("ADMIN_URL").'/css/custom_admin.css' }}" rel="stylesheet">
    @stack('css')
</head>
<body>
<div class="d-flex @if(!$isSidebarVisible) toggled @endif @if($isDarkModeVisible) darkmode @endif" id="wrapper">
    <!-- Sidebar -->
    @include('layouts.admin.sidebar')
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav id="topNavBar" class="navbar navbar-expand-lg @if($isDarkModeVisible) navbar-dark bg-dark @else navbar-light bg-light @endif border-bottom">
            <a class="" id="menu-toggle"><i class="fa fa-signal flip-menu-icon"></i> @yield('title')</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->email }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link" href="#" id="setDarkMode">
                            <i class="fas fa-adjust"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
        <div class="page-content container-fluid">
            @yield('content')
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->
<div id="loading-container">
    <div class="spinner-border text-light" id="loading" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Bootstrap core JavaScript -->
<script src="{{ env("ADMIN_URL").'/js/admin.js' }}"></script>
<script src="{{ env("ADMIN_URL").'/js/custom_admin.js' }}"></script>
<script src="{{ env("ADMIN_URL").'/dist/moment.min.js' }}"></script>
<script src="{{ env("ADMIN_URL").'/dist/daterangepicker.js' }}"></script>
<script src="{{ env("ADMIN_URL").'/dist/datatables.min.js' }}"></script>
<script type="application/javascript">
    let token = document.head.querySelector('meta[name="csrf-token"]');
    var restUrl = '{{ e(env("API_URL")) }}';
    var restUserId = {{ e(Auth::user()->id) }};
    var restHeader = {
        "Accept": "application/json",
        "Authorization": "Bearer {{  e( Auth::user()->api_token ) }}"
    };
    var restToken = "{{  e( Auth::user()->api_token ) }}";
</script>
<script src="{{ env("ADMIN_URL").'/js/custom_admin.js' }}"></script>
<script src="{{ env("ADMIN_URL").'/js/bootstrap-notify.min.js' }}"></script>
@stack('scripts')
</body>
</html>
