@extends('layouts.web')

@section('main', 'service')
@section('title', $meta->title)
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', [
        'caption' => $meta->h1, /* $service->breadcrumb->caption */
        'description' => '', /* $service->breadcrumb->description */
        'image' => $service->breadcrumb->getImage(),
    ])
@endsection

@section('content')
    <div class="mt-4">
        ****
    </div>
@endsection
