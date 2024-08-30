@extends('layouts.web')

@section('main', 'services container-xl')
@section('title', $meta->title)
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', ['breadcrumb_info' => $breadcrumb])
@endsection

@section('content')
    <div class="mt-4">
        @foreach($services as $service)
            <div>
                <a href="{{ route('web.service.view', $service->slug) }}">{{ $service->name}} </a>
            </div>
        @endforeach
    </div>
@endsection
