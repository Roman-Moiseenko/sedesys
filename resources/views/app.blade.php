<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{Vite::asset('resources/images/admin/32x32.png')}}" size="32x32">
    <link rel="icon" href="{{Vite::asset('resources/images/admin/192x192.png')}}" size="192x192">
    <link rel="apple-touch-icon" href="{{Vite::asset('resources/images/admin/180x180.png')}}" size="180x180">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>

    <!--script src="//cdn.jsdelivr.net/npm/@element-plus/icons-vue"></script-->
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
