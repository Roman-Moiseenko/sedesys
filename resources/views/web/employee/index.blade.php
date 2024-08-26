@extends('layouts.web')

@section('main')
    employees container-xl
@endsection

@section('title', $meta->title)
@section('description', $meta->description)

@section('content')
    <h1 class="my-4">{{ $meta->h1 }}</h1>
    <div class="mt-4">
        @foreach($employees as $employee)
            <div>
                <a href="{{ route('web.employee.view', $employee) }}">{{ $employee->fullname->getFullName() }} </a>
            </div>
        @endforeach
    </div>

    Виджет с услугами <br>
    Виджет с работами <br>
@endsection
