@extends('layouts.web')

@section('main')
    service container-xl
@endsection

@section('title', $service->title . ' - ')
@section('description', $service->description)

@section('content')
    <h1 class="my-4">{{ $service->caption }}</h1>
    <div class="mt-4">
        ****
    </div>
@endsection
