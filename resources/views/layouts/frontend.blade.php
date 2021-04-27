@php
    $version = '0.0.8';
@endphp
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

    <title>@yield('title') {{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <meta name="description" content="@yield('description')"/>

    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route("web_home") }}/@yield('slug', '')" />
    <meta property="og:image" content="{{ route("web_home") }}/@yield('image', '')" />
    <meta property="og:image:secure_url" content="{{ route("web_home") }}/@yield('image', '')" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="250" />
    <meta property="og:image:alt" content="@yield('image_description', '')" />

    <!-- Styles -->
    <link href="{{ asset('css/frontend.css') }}?v={{$version}}" rel="stylesheet">
    <link href="{{ asset('css/custom_frontend.css') }}?v={{$version}}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <div id="app">
        <!-- Vertical navbar -->
        @include('layouts.frontend.sidebar')

        <!-- End vertical navbar -->
        @include('layouts.frontend.topbar')

        <main class="page-content" id="content">
            <div class="container-fluid">
                @yield("content")
            </div>
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/frontend.js') }}?v={{$version}}"></script>
    <script src="{{ asset('js/custom_frontend.js') }}?v={{$version}}"></script>
    @stack('scripts')
</body>
</html>
