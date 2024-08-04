@php
/**
* $page - class Page ()
* Поля:
* @property int $id
* @property int $parent_id
* @property string $name
* @property string $slug
* @property string $title
* @property string $description
* @property string $template
* @property string $text
* @property bool $published
* @property int $sort
* @property Carbon $created_at
* @property Carbon $updated_at
* @property Carbon $published_at
* @property Photo $photo
* @property Page $parent
*/
@endphp

@extends('layouts.web')

@section('main')
pages container-xl
@endsection

@section('title', $page->title)
@section('description', $page->description)

@section('content')
<!--template:q-->
<h1 class="my-4">{{ $page->name }}</h1>
<div class="mt-4">
    {!! $page->text !!}
</div>
@endsection
