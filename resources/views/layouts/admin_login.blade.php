<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
<style>
    html{
        height: 100%;
    }
    body{
        display: flex;
        align-items: center;
        height: 100%;
    }
    #app {
        background-image: url('{{ \App\Models\Settings\Settings::getValue('default.admin_login_background') }}');
        /* position: fixed;*/
        width: 100%;
        height: 100%;
    }
    .transparent{
        background: rgba(255, 255, 255, 0.55);

        padding: 15px;
        margin: auto;
    }
    .bottom{
        position: fixed;
        bottom: 25px;
        color:#FFF;
        left: 25px;
        color: #FFF;
    }
</style>
    <div id="app" class="h-100">
        @yield('content')
    </div>
</body>
</html>
