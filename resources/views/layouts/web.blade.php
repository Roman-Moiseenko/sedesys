<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ًApplication</title>
    @yield('head')
    @vite('resources/css/web.css')
</head>
<body class="@yield('body')">

<main class="@yield('main')">
    @yield('content')
</main>

@vite('resources/js/web.js')
</body>
</html>
