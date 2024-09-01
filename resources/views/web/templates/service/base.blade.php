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

@section('main', 'service container-xl')
@section('title', $meta->title)
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', ['breadcrumb_info' => $breadcrumb])
@endsection

@section('content')

    <div class="my-5">
        <h2>Информационный блок</h2>
        <div>
            Цена за услугу {{ price($service->price) }}
        </div>
        <div>
            Длительность {{ duration($service->duration) }}
        </div>
        @if($service->gallery()->count() > 0)
            <div class="d-flex">
                @foreach($service->gallery as $image)
                    <img src="{{ $image->getThumb('card') }}" class="mx-1 rounded-2">
                @endforeach
            </div>
        @endif
    </div>

    <div class="my-5">
        {!! $service->text !!}
    </div>

    @if($service->employees()->count() > 0)
        <div class="my-5">
            <h2>Специалисты</h2>
            <div class="row">
                @foreach($service->employees as $employee)
                    <div class="col-lg-4">
                        <div class="card">
                            <img src="{{ $employee->getImage() }}">
                            <div class="card-body">
                                <h3>{{ $employee->fullname->getShortName() }}</h3>


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($service->reviews()->count() > 0)
        <div class="my-5">
            <h2>Отзывы</h2>
        </div>
    @endif

    @if($service->extras()->count() > 0)
        <div class="my-5">
            <h2>Дополнительные услуги</h2>
            <table style="width: 100%">
                <tbody>
                @foreach($service->extras as $extra)
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between align-items-end position-relative">
                                <div style="width: 75%; flex-grow: 1;">
                                    <span class="bg-dots-list">{{ $extra->name }}</span>
                                </div>
                                <div class="dots-list">
                                    <span class="bg-dots-list">{{ price($extra->price) }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    @endif

    @if($service->examples()->count() > 0)
        <div class="my-5">
            <h2>Примеры наших работ</h2>
            <div class="row">
                @foreach($service->examples as $example)
                    <div class="col-lg-4">
                        <div class="card">
                            <img src="{{ $example->getImage(1) }}">
                            <div class="card-body">
                                <h3>{{ $example->title }}</h3>
                                <div class="fs-7">{{ $example->description  }}</div>
                                <div class="text-success">
                                    {{ price($example->cost) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection

