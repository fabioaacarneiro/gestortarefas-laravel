<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand navbar-logo" href="{{ route('home') }}"><img
                src="{{ asset('assets/img/small/ico-dark-theme.png') }}" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('resources') }}">Recursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('signup') }}">Crie sua conta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contato</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('developer') }}">Desenvolvedor</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
