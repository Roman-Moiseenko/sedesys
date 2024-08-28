@extends('layouts.web')

@section('main', 'classification')
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
        @foreach($classification->children as $child)
            <div>
                <a href="{{ route('web.classification.view', $child->slug) }}">{{ $child->name }} </a>
            </div>
        @endforeach
    </div>
@endsection
