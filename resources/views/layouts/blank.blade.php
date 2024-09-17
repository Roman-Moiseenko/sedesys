<!DOCTYPE html>

<html class="" lang="ru-RU">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Страница ошибок')</title>
    @vite('resources/sass/web.scss')
    <link rel="preload" as="style" href="/custom/custom.css" />
</head>
<body>
@yield('content')

@vite('resources/js/web.js')
</body>

</html>
