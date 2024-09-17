@extends('layouts.web')

@section('breadcrumbs')
@endsection

@section('content')
    <style>
        #main-image {
            background-image: url({{ Vite::asset('resources/images/home/section-image.jpg') }});
        }
    </style>
    <section id="main-image" class="">
        <div class="container-xl info-block">
            <div class="section-title">
                <h1>Система предоставления услуг SeDeSys</h1>
                <div class="">
                    CRM / CMS по управлению услугами для малого бизнеса
                </div>
            </div>
            <div class="d-flex justify-content-between hide-mobile">
                <div class="main-button">
                    <button class="btn btn-outline-dark">Узнать цену</button>
                </div>
                <div class="main-vk">
                    <a href="https://vk.com/website39.site" target="_blank" aria-label="аккаунт в социальной сети ВКонтакте"><i class="fab fa-vk"></i></a>
                </div>

            </div>
        </div>
    </section>


    <div class="container">
        <h1> Клиентская часть </h1>
        <div>
            Проект- по разработке CMS для компаний по предоставлению услуг населению.
            <br>
            CMS SeDeSys подойдет в первую очередь для малого бизнеса.
        </div>
        <br> ***
        <br> ***

        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <div class="feedback" data-id="1"></div>
            </div>
        </div>
        <br> ***
        <br> ***
        <br> ***
        <br> ***
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <div class="feedback" data-id="2"></div>
            </div>
        </div>

        <br> ***
        <br> ***
        Разработка проекта ведется <a href="https://website39.ru">Калининградской веб-студией Web39</a>
    </div>
    {!! $schema->HomePage() !!}
@endsection
