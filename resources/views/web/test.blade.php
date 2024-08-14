@extends('layouts.web')

@section('breadcrumbs')
@endsection

@section('content')
    <div class="container">
        <h1> Тест </h1>
            @php

            phpinfo();
            @endphp
    </div>

@endsection
