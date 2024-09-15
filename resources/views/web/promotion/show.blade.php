@extends('layouts.web')

@section('main', 'promotion container-xl')
@section('title', $meta->title . ' - ')
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', ['breadcrumb_info' => $breadcrumb])
@endsection

@section('content')
    <div class="mt-4">
        @foreach($promotion->items as $item)
            <div>
                {{ $item->name }}
            </div>
        @endforeach
    </div>
@endsection