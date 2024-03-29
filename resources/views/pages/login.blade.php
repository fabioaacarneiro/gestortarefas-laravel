@extends('templates.login_layout') @section('content')

@section('content')
    <div class="login-wrapper card">
        <div class="login-box p-5 rounded-4  shadow shadow-lg">
            <h3 class="text-center card-title">Bem vindo - SheepTask</h3>
            <hr />
            <form action="{{ route('login.submit') }}" method="post">
                @csrf
                {{-- usurname --}}
                <div class="mb-3 form-floating">
                    <input type="text" name="email" id="email" class="form-control" required placeholder="Usuário"
                        value="{{ old('email') }}" />
                    <label for="email" class="form-label">Usuário</label>
                    @error('email')
                        <div class="text-warning">{{ $errors->get('email')[0] }}</div>
                    @enderror
                </div>
                {{-- password --}}
                <div class="mb-3 form-floating">
                    <input type="password" name="password" id="password" class="form-control" required placeholder="Senha"
                        value="{{ old('username') }}" />
                    <label for="password" class="form-label">Senha</label>
                    @error('password')
                        <div class="text-warning">{{ $errors->get('password')[0] }}</div>
                    @enderror
                </div>
                {{-- submit button --}}
                <div class="d-grid my-2">
                    <button type="submit" class="btn btn-outline-success">Logar</button>
                </div>
                <div class="d-grid">
                    <a class="btn btn-outline-info " href="{{ route('signup') }}">Criar uma
                        conta</a>
                </div>

                {{-- erro throws --}}
                @if (session()->has('login_error'))
                    <div class="alert alert-danger text-center mt-2 p-1">{{ session()->get('login_error') }}</div>
                @endif

            </form>
        </div>
    </div>

@endsection
