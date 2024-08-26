@extends('layouts.web')

@section('main')
    specialization container-xl
@endsection

@section('title', $meta->title)
@section('description', $meta->description)

@section('content')
    <h1 class="my-4">{{ $meta->h1 }}</h1>
    <div class="mt-4">
        @foreach($specialization->employees as $employee)
            <div>
                <a href="{{ route('web.employee.view', $employee) }}">{{ $employee->fullname->getFullName() }} </a>
            </div>
        @endforeach
    </div>
@endsection
