@extends('layouts.web')

@section('main')
    classifications container-xl
@endsection

@section('title', 'Услуги')
@section('description', '***')

@section('content')
    <h1 class="my-4">Наши услуги</h1>
    <div class="mt-4">
        @foreach($classifications as $classification)
            <div>
                <a href="{{ route('web.classifications.view', $classifications) }}">{{ $classifications->name }} </a>
            </div>
        @endforeach
    </div>
@endsection
