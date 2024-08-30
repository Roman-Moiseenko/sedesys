@extends('layouts.web')

@section('main', 'classification container-xl')
@section('title', $meta->title . ' - ')
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', ['breadcrumb_info' => $breadcrumb])
@endsection

@section('content')
        @foreach($classification->children as $child)
            <div>
                <a href="{{ route('web.classification.view', $child->slug) }}">{{ $child->name }} </a>
            </div>
        @endforeach
    </div>
@endsection
