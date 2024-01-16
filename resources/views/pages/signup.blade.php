@extends('templates.login_layout') @section('content')

@section('content')
    <div class="m-3">
        <a href="{{ route('login') }}" class="btn btn-outline-info">Voltar para o login</a>
    </div>
    <div class="login-wrapper card">
        <div class="login-box p-5 rounded-4">
            <h3 class="text-center card-title">Cadastro de usuário - GTask</h3>
            <hr />
            <form action="{{ route('login.submit') }}" method="post">
                @csrf
                {{-- usurname --}}
                <div class="mb-3 form-floating">
                    <input type="text" name="text_username" id="text_username" class="form-control" required
                        placeholder="Usuário" value="{{ old('text_username') }}" />
                    <label for="text_username" class="form-label">Nome de Usuário da conta</label>
                    @error('text_username')
                        <div class="text-warning">{{ $errors->get('text_username')[0] }}</div>
                    @enderror
                </div>
                {{-- e-mail --}}
                <div class="mb-3 form-floating">
                    <input type="text" name="text_username" id="text_username" class="form-control" required
                        placeholder="Usuário" value="{{ old('text_username') }}" />
                    <label for="text_username" class="form-label">E-Mail para cadastro</label>
                    @error('text_username')
                        <div class="text-warning">{{ $errors->get('text_username')[0] }}</div>
                    @enderror
                </div>
                {{-- e-mail confirm --}}
                <div class="mb-3 form-floating">
                    <input type="text" name="text_username" id="text_username" class="form-control" required
                        placeholder="Usuário" value="{{ old('text_username') }}" />
                    <label for="text_username" class="form-label">Confirme o seu E-Mail</label>
                    @error('text_username')
                        <div class="text-warning">{{ $errors->get('text_username')[0] }}</div>
                    @enderror
                </div>
                {{-- password --}}
                <div class="mb-3 form-floating">
                    <input type="password" name="text_password" id="text_password" class="form-control" required
                        placeholder="Senha" value="{{ old('text_username') }}" />
                    <label for="text_password" class="form-label">Crie uma senha</label>
                    @error('text_password')
                        <div class="text-warning">{{ $errors->get('text_password')[0] }}</div>
                    @enderror
                </div>
                {{-- password confirm --}}
                <div class="mb-3 form-floating">
                    <input type="password" name="text_password" id="text_password" class="form-control" required
                        placeholder="Senha" value="{{ old('text_username') }}" />
                    <label for="text_password" class="form-label">Confirme a senha criada</label>
                    @error('text_password')
                        <div class="text-warning">{{ $errors->get('text_password')[0] }}</div>
                    @enderror
                </div>
                {{-- submit button --}}
                <div class="d-grid my-2">
                    <button type="submit" class="btn btn-outline-success">Criar minha conta!</button>
                </div>

                {{-- erro throws --}}
                @if (session()->has('login_error'))
                    <div class="alert alert-danger text-center p-1">{{ session()->get('login_error') }}</div>
                @endif

            </form>
        </div>
    </div>

@endsection
