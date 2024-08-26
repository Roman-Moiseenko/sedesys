@extends('layouts.web')

@section('main')
    classifications container-xl
@endsection

@section('title', $meta->title)
@section('description', $meta->description)

@section('content')
    <h1 class="my-4">{{ $meta->h1 }}</h1>
    <div class="mt-4">
        @foreach($classifications as $classification)
            <div>
                <a href="{{ route('web.classifications.view', $classifications) }}">{{ $classifications->name }} </a>
            </div>
        @endforeach
    </div>
@endsection
