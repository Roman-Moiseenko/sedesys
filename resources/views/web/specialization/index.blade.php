@extends('layouts.web')

@section('main')
    specializations container-xl
@endsection

@section('title', 'Специалисты')
@section('description', '***')

@section('content')
    <h1 class="my-4">Специализация</h1>
    <div class="mt-4">
        @foreach($specializations as $specialization)
            <div>
                <a href="{{ route('web.specialization.view', $specialization) }}">{{ $specialization->name }} </a>
            </div>
        @endforeach
    </div>
@endsection
