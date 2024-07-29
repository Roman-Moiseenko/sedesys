@extends('layouts.web')

@section('main')
    employee container-xl
@endsection

@section('title', $employee->fullname->getShortName() . ' - ')
@section('description', '***')

@section('content')
    <h1 class="my-4">{{ $employee->fullname->getFullName() }}</h1>
    <div class="mt-4">
        ****
    </div>
@endsection
