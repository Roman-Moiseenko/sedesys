@php
    /**
    * $service - class Service ()
    * Поля:
     * @property int $id
     * @property int $classification_id
     * @property string $name
     * @property string $slug
     * @property string $text
     * @property bool $active
     * @property int $price // В рублях
     * @property int $duration // В минутах
     * @property string $template //Шаблон, либо общий, либо для каждой услуги свой
     * @property string $data // json данных, можно использовать в шаблоне
     * @property Carbon $created_at
     * @property Carbon $updated_at
     *
     * @property Classification $classification
     * @property Photo $image //Главное фото на карточку
     * @property Photo $icon //Иконка в меню, в список и т.п.
     * @property Meta $meta
     * @property Photo[] $gallery //Галерея изображений
    */
@endphp

@extends('layouts.web')

@section('main', ' service container-xl')
@section('title', $service->meta->title)
@section('description', $service->meta->description)

@section('content')
    <!--template:Базовая услуга-->
    <h1 class="my-4">{{ $service->meta->h1 }}</h1>
    <div>
        <h2>Информационный блок</h2>
        <div>
            Цена за услугу {{ price($service->price) }}
        </div>
        <div>
            Длительность {{ $service->getDurationText() }}
        </div>
        <div class="d-flex">
            @foreach($service->gallery as $image)
                <img src="{{ $image->getThumb('card') }}" class="mx-1 rounded-2">
            @endforeach
        </div>
    </div>


    <div class="mt-4">
        {!! $service->text !!}
    </div>
    <div>
        Мастера
    </div>
    <div>
        Отзывы
    </div>
    <div>
        Используемые материалы
    </div>
    <div>
        Дополнительные услуги или вариации??
    </div>




@endsection
