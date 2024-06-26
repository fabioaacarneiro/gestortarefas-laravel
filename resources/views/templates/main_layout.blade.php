<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link id="favicon-site" href="{{ asset('assets/img/small-logo.png') }}" rel="shortcut icon" />
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <main class="d-flex flex-column min-vh-100">

        @yield('content')

        <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
    </main>
    <script src="{{ asset('assets/scripts/script.js') }}"></script>
    <script src="https://unpkg.com/htmx.org@1.9.12"></script>
</body>

</html>
