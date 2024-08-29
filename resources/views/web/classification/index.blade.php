@extends('layouts.web')

@section('main', 'classifications')
@section('title', $meta->title)
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', ['breadcrumb_info' => $breadcrumb])
@endsection

@section('content')
    <div class="mt-4">
        @foreach($classifications as $classification)
            <div>
                <a href="{{ route('web.classification.view', $classification->slug) }}">{{ $classification->name }} </a>
            </div>
        @endforeach
    </div>
@endsection
