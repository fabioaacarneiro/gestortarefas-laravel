    @extends('templates.login_layout') @section('content')

    @section('content')

        @include('partials.visitant.nav')

        <div class="my-auto d-flex justify-content-center">
            <div class="card p-3 rounded-3 shadow shadow-lg bg-dark" style="max-width:300px;">
                <div class="mx-auto">
                    <img src="{{ asset('assets/img/small/ram-logo-dark-theme.png') }}" alt="ramtask logo"
                        style="width: 7rem; margin-top: -5rem">
                </div>
                <h4 class="text-center card-title my-3">Bem vindo ao RamTask</h4>
                <form action="{{ route('login.submit') }}" method="post">
                    @csrf

                    <div class="row">

                        <div class="col-12 mb-3">
                            {{-- usurname --}}
                            <div class="form-floating form-floating-sm">
                                <input type="text" name="email" id="email" class="form-control" required
                                    placeholder="Usuário" value="{{ old('email') }}" />
                                <label for="email" class="form-label">E-mail</label>
                                @error('email')
                                    <div class="text-warning">{{ $errors->get('email')[0] }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            {{-- password --}}
                            <div class="form-floating">
                                <input type="password" name="password" id="password" class="form-control" required
                                    placeholder="Senha" value="{{ old('username') }}" />
                                <label for="password" class="form-label">Senha</label>
                                @error('password')
                                    <div class="text-warning">{{ $errors->get('password')[0] }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- submit button to login --}}
                        <div class="col-12 my-2">
                            <button type="submit" class="btn btn-success w-100">Logar <i
                                    class="bi bi-door-open-fill"></i></button>
                        </div>

                        {{-- link button to signup --}}
                        <div class="col-12 my-2">
                            <a class="btn btn-info w-100" href="{{ route('signup') }}">Criar uma conta <i
                                    class="bi bi-person-check-fill"></i></a>
                        </div>

                        {{-- link button to loggin with google --}}
                        <div class="col-12 mt-2">
                            <a href="{{ $authUrl }}" class="btn btn-light text-dark w-100">Continue com Google <i
                                    class="bi bi-google"></i></a>
                        </div>

                        {{-- erro throws --}}
                        @if (session()->has('login_error'))
                            <div class="alert alert-danger text-center">{{ session()->get('login_error') }}
                            </div>
                        @endif

                </form>
            </div>
        </div>

    @endsection
