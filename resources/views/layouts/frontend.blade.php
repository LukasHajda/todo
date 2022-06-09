<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ env('APP_NAME') }} | @yield('title')
    </title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
</head>
<body>

@include('frontend._partials._navbar')
@yield('content')

<script src="{{ asset('js/script.min.js') }}" defer></script>
@yield('js')

</body>
</html>
