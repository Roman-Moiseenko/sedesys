@extends('layouts.web')

@section('main', 'services')
@section('title', $meta->title)
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', [
        'caption' => $meta->h1, /* $service->breadcrumbs->caption */
        'description' => '', /* $service->breadcrumbs->description */
        'image' => '/cache/gallery/1/original_64.jpg' /* $service->breadcrumbs->image */
    ])
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
