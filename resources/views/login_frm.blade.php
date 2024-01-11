@extends('templates.login_layout') @section('content')
    <div class="login-wrapper card">
        <div class="login-box p-5 rounded-4">
            <h3 class="text-center card-title">Login</h3>
            <hr />
            <form action="{{ route('main.login_submit') }}" method="post">
                @csrf
                {{-- usurname --}}
                <div class="mb-3">
                    <label for="text_username" class="form-label">Usuário</label>
                    <input type="text" name="text_username" id="text_username" class="form-control" required
                        placeholder="Usuário" value="{{ old('text_username') }}" />
                    @error('text_username')
                        <div class="text-warning">{{ $errors->get('text_username')[0] }}</div>
                    @enderror
                </div>
                {{-- password --}}
                <div class="mb-3">
                    <label for="text_password" class="form-label">Senha</label>
                    <input type="password" name="text_password" id="text_password" class="form-control" required
                        placeholder="Senha" value="{{ old('text_username') }}" />
                    @error('text_password')
                        <div class="text-warning">{{ $errors->get('text_password')[0] }}</div>
                    @enderror
                </div>
                {{-- submit button --}}
                <div class="mb-3">
                    <button type="submit" class="btn btn-dark w-100">Logar</button>
                </div>

                {{-- erro throws --}}
                @if (session()->has('login_error'))
                    <div class="alert alert-danger text-center p-1">{{ session()->get('login_error') }}</div>
                @endif

            </form>
        </div>
    </div>
@endsection
