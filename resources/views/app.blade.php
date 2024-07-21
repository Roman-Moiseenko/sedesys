<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ 'SeDeSys - CMS Управления бизнесом' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <!-- -->
    @inertiaHead
</head>
<body>
@inertia
@stack('vendors')
@stack('scripts')
</body>
</html>
