@extends('layouts.web')

@section('main', 'service')
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
        ****
    </div>
@endsection
