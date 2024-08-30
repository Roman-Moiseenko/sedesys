@extends('layouts.web')

@section('main', 'specializations container-xl')
@section('title', $meta->title)
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', ['breadcrumb_info' => $breadcrumb])
@endsection

@section('content')
    <div class="my-4 row">
        @foreach($specializations as $specialization)
            <div class="col-lg-4 col-12">
                <a href="{{ route('web.specialization.view', $specialization->slug) }}">
                    <img src="{{ $specialization->getImage('card') }}" style="width: 100%;"/>
                    <div class="fs-4">
                        {{ $specialization->name }}
                    </div>

                </a>
            </div>
        @endforeach
    </div>

    Виджет с услугами <br>
    Виджет с работами <br>
@endsection

