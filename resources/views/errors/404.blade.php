@extends('layouts.blank')
@section('title', 'Страница 404')

@section('breadcrumbs')
@endsection

@section('main', 'error')
@section('content')

    <div class="container-xl mt-5">
        <h1>Страница не найдена. Ошибка 404</h1>
        <div class="fs-5">
            Мы не нашли страницу по Вашему запросу. Возможно она была удалена, либо никогда не существовала.
        </div>
        <div class="fs-5">
            <a href="/" class="btn btn-success">Вернуться назад</a>
        </div>
    </div>

@endsection
