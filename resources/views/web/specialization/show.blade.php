@extends('layouts.web')

@section('main', 'specialization')
@section('title', $meta->title)
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', ['breadcrumb_info' => $breadcrumb])
@endsection

@section('content')
    <div class="mt-4">
        @foreach($specialization->employees as $employee)
            <div>
                <a href="{{ route('web.employee.view', $employee->slug) }}">{{ $employee->fullname->getFullName() }} </a>
            </div>
        @endforeach
    </div>
@endsection
