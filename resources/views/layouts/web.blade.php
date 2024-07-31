<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{Vite::asset('resources/images/favicon/32x32.png')}}" size="32x32">
    <link rel="icon" href="{{Vite::asset('resources/images/favicon/192x192.png')}}" size="192x192">
    <link rel="apple-touch-icon" href="{{Vite::asset('resources/images/favicon/180x180.png')}}" size="180x180">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Система управления услугами')</title>
    <meta name="description"
          content="@yield('description', 'Универсальная CRM для малого бизнеса в сфере услуг. Индивидуальная настройка под каждый проект')">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    @yield('head')
    @vite('resources/sass/web.scss')
</head>
<body class="@yield('body')">

@include('web.header')
@include('flash::message')
@section('breadcrumbs')
    <div class="container-xl">
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::view('web.breadcrumbs') }}
    </div>
@show
<main class="@yield('main')">
    @yield('content')
</main>
<!--POP-UP ОКНА-->

<!--FOOTER-->
@include('web.footer')
<button id="upbutton" type="button" class="scrollup" aria-label="В начало"><i class="fa fa-arrow-up"></i></button>
@vite('resources/js/web.js')
@stack('scripts')
</body>
</html>
