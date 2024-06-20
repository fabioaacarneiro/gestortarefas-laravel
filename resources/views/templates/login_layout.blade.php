<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link id="favicon-site" href="{{ asset('assets/img/small-logo.png') }}" rel="shortcut icon" />

    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}"> --}}
</head>

<body>
    <main class="d-flex flex-column min-vh-100">
        @yield('content')
        <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/scripts/script.js') }}"></script>
    </main>
</body>

</html>
