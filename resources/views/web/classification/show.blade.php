@extends('layouts.web')

@section('main')
    classification container-xl
@endsection

@section('title', $classification->title . ' - ')
@section('description', $classification->description)

@section('content')
    <h1 class="my-4">{{ $classification->caption }}</h1>
    <div class="mt-4">
        ****
    </div>
@endsection
