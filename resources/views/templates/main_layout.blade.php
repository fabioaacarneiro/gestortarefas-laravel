<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link id="favicon-site" href="{{ asset('assets/img/small-logo.png') }}" rel="shortcut icon" />
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/dark/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome via CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

</head>

<body>
    <main class="d-flex flex-column min-vh-100">

        @yield('content')

        <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
    </main>
    
    <!-- Incluir Axios via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('assets/scripts/script.js') }}"></script>
    <script src="https://unpkg.com/htmx.org@1.9.12"></script>
</body>

</html>
