@extends('layouts.web')

@section('main', 'employees')
@section('title', $meta->title)
@section('description', $meta->description)

@section('breadcrumbs')
    @include('web.breadcrumbs.background', ['breadcrumb_info' => $breadcrumb])
@endsection

@section('content')
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
