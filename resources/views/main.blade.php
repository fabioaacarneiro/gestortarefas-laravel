@extends('templates.main_layout')
@section('content')
    @include('partials.nav')

    @include('partials.task.tasks', ['tasks' => $tasks])

    @include('partials.footer')
@endsection
