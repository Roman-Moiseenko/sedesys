@extends('layouts.web')

@section('main')
    service container-xl
@endsection

@section('title', $meta->title)
@section('description', $meta->description)

@section('content')
    <h1 class="my-4">{{ $meta->h1 }}</h1>
    <div class="mt-4">
        ****
    </div>
@endsection
