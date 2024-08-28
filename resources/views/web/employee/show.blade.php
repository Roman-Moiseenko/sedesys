@extends('layouts.web')

@section('main', 'employee')
@section('title', $employee->fullname->getShortName() . ' - ')
@section('description', '***')

@section('breadcrumbs')
    @include('web.breadcrumbs.background', [
        'caption' => $employee->fullname->getShortName(), /* $service->breadcrumbs->caption */
        'description' => '', /* $service->breadcrumbs->description */
        'image' => '/cache/gallery/1/original_64.jpg' /* $service->breadcrumbs->image */
    ])

@endsection
@section('content')
    <h1 class="my-4">{{ $employee->fullname->getFullName() }}</h1>
    <div class="mt-4">
        ****
    </div>
@endsection
