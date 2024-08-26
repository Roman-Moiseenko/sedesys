@extends('layouts.web')

@section('main')
    services container-xl
@endsection

@section('title', $meta->title)
@section('description', $meta->description)

@section('content')
    <h1 class="my-4">{{ $meta->h1 }}</h1>
    <div class="mt-4">
        @foreach($services as $service)
            <div>
                <a href="{{ route('web.service.view', $service) }}">{{ $service->name}} </a>
            </div>
        @endforeach
    </div>
@endsection
