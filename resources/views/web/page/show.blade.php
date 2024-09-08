@extends('layouts.web')

@section('main', 'pages container-xl')
@section('title', $meta->title)
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', ['breadcrumb_info' => $breadcrumb])
@endsection

@section('content')
    <div class="mt-4">
        {!! $page->text !!}
    </div>
@endsection
