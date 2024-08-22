@extends('layouts.web')

@section('main')
    pages container-xl
@endsection

@section('title', $page->meta->title)
@section('description', $page->meta->description)

@section('content')
    <!--template:Базовый текстовый, без форматирования -->
    <h1 class="my-4">{{ $page->meta->h1 }}</h1>
    <div class="mt-4">
        {!! $page->text !!}
    </div>
@endsection