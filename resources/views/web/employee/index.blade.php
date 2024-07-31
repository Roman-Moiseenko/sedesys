@extends('layouts.web')

@section('main')
    employees container-xl
@endsection

@section('title', 'Специалисты')
@section('description', '***')

@section('content')
    <h1 class="my-4">Наши специалисты</h1>
    <div class="mt-4">
        @foreach($employees as $employee)
            <div>
                <a href="{{ route('web.employee.view', $employee) }}">{{ $employee->fullname->getFullName() }} </a>
            </div>
        @endforeach
    </div>
@endsection
