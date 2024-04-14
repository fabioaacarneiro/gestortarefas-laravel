@extends('templates.login_layout') @section('content')

@section('content')
    @include('partials.visitant.nav')
    <div class="login-wrapper card">
        <div class="login-box p-3 rounded-4">
            <div class="container-logo-ramtask">
                <img id="" class="logo-ramtask" src="{{ asset('assets/img/small/ram-logo-dark-theme.png') }}"
                    alt="ramtask logo">
            </div>
            <h4 class="text-center card-title pb-3">Cadastro de usuário</h4>
            <form action="{{ route('signup.submit') }}" method="post">
                @csrf

                {{-- usurname --}}
                <div class="mb-3 form-floating">
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Usuário"
                        value="{{ old('name') }}" />
                    <label for="name" class="form-label">Nome de Usuário da conta</label>
                    @error('name')
                        <div class="text-warning">{{ $errors->get('name')[0] }}</div>
                    @enderror
                </div>

                {{-- e-mail --}}
                <div class="mb-3 form-floating">
                    <input type="email" name="email" id="email" class="form-control" required placeholder="E-Mail"
                        value="{{ old('email') }}" />
                    <label for="email" class="form-label">E-Mail para cadastro</label>
                    @error('email')
                        <div class="text-warning">{{ $errors->get('email')[0] }}</div>
                    @enderror
                </div>

                {{-- e-mail confirm --}}
                <div class="mb-3 form-floating">
                    <input type="email" name="email_confirm" id="email_confirm" class="form-control" required
                        placeholder="E-Mail" value="{{ old('email_confirm') }}" />
                    <label for="email_confirm" class="form-label">Confirme o seu E-Mail</label>
                    @error('email_confirm')
                        <div class="text-warning">{{ $errors->get('email_confirm')[0] }}</div>
                    @enderror
                </div>

                {{-- password --}}
                <div class="mb-3 form-floating">
                    <input type="password" name="password" id="password" class="form-control" required placeholder="Senha"
                        value="{{ old('username') }}" />
                    <label for="password" class="form-label">Crie uma senha</label>
                    @error('password')
                        <div class="text-warning">{{ $errors->get('password')[0] }}</div>
                    @enderror
                </div>

                {{-- password confirm --}}
                <div class="mb-3 form-floating">
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" required
                        placeholder="Senha" value="{{ old('username') }}" />
                    <label for="password_confirm" class="form-label">Confirme a senha criada</label>
                    @error('password_confirm')
                        <div class="text-warning">{{ $errors->get('password_confirm')[0] }}</div>
                    @enderror
                </div>

                {{-- submit button --}}
                <div class="d-grid my-2">
                    <button type="submit" class="btn btn-outline-success">Criar minha conta!</button>
                </div>

                {{-- erro throws --}}
                @if (session()->has('signup_error'))
                    <div class="alert alert-danger text-center p-1">{{ session()->get('signup_error') }}</div>
                @endif

                {{-- success confirm --}}
                @if (session()->has('signup_success'))
                    <div class="alert alert-success text-center p-1">{{ session()->get('signup_success') }}</div>
                    <div class="d-grid"><a href="{{ route('login') }}" class="btn btn-succes">Ir para login</a></div>
                @endif

            </form>
        </div>
    </div>

@endsection
