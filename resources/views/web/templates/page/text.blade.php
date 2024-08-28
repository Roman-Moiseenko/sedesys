@extends('layouts.web')

@section('main', 'pages')
@section('title', $meta->title . ' - ')
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', [
        'caption' => $meta->h1, /* $service->breadcrumbs->caption */
        'description' => '', /* $service->breadcrumbs->description */
        'image' => '/cache/gallery/1/original_64.jpg' /* $service->breadcrumbs->image */
    ])
@endsection

@section('content')
    <!--template:Базовый текстовый, без форматирования -->
    <h1 class="my-4">{{ $meta->h1 }}</h1>
    <div class="mt-4">
        {!! $page->text !!}
    </div>
@endsection
