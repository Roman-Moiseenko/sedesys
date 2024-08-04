@extends('layouts.web')

@section('main')
pages container-xl
@endsection

@section('title', $title)
@section('description', $description)

@section('content')
<!--template:qqqqqqqq-->
<h1 class="my-4">{{ $page->name }}</h1>
<div class="mt-4">
    {!! $page->text !!}
</div>
@endsection
