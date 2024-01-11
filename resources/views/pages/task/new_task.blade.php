@extends('templates.main_layout')
@section('content')
    @include('partials.main.nav')

    @include('partials.task.form_new_task')

    @include('partials.main.footer')
@endsection
