<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-98344414-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-98344414-1');
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom_frontend.css') }}" rel="stylesheet">
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
        background-image: url('/{{ \App\Models\Settings\Settings::getValue('default.frontend_login_background') }}');
        /* position: fixed;*/
        width: 100%;
        height: 100%;
    }
    .transparent{
        background: rgba(255, 255, 255, 0.75);

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
    <!-- Scripts -->
    <script src="{{ asset('js/frontend.js') }}" defer></script>
    <script src="{{ asset('js/custom_frontend.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
