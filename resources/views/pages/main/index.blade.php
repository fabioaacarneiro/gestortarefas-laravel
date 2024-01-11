@extends('templates.main_layout')
@section('content')
    @include('partials.main.nav')

    @include('partials.task.tasks', ['tasks' => $tasks])

    @include('partials.main.footer')
@endsection
