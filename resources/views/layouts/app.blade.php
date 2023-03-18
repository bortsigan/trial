<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @auth
    <link href="{{ asset('css/home-design.css') }}" rel="stylesheet">
    @endauth
</head>
<body class="{{ auth()->user() ? 'home-design' : '' }}">
    
    <div id="app">
        @include('layouts.nav')
        @guest
        @yield('content')
        @else
        
        <order-component></order-component>
        @endguest
    </div>
    <!-- Scripts -->
    @auth
   <script src="{{ asset('js/app.js') }}" defer></script> 

   @endauth
</body>
</html>
