@extends('layouts.web')

@section('main', 'employee container-xl')
@section('title', $meta->title)
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', ['breadcrumb_info' => $breadcrumb])
@endsection
@section('content')
    <h1 class="my-4">{{ $employee->fullname->getFullName() }}</h1>
    <div class="mt-4">
        ****
    </div>
@endsection
