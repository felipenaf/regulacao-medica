<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('head')

    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <form action="{{ route('autenticacao') }}" method="post">
                    @csrf

                    <label for="email">
                        Email:
                        <input
                            type="text"
                            name="email"
                            value="{{ session('email', '')}}"
                            required
                        >
                    </label>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <br>

                    <label for="senha">
                        Senha:
                        <input
                            type="password"
                            name="senha"
                            required
                        >
                    </label>

                    @error('senha')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <br>

                    @if(session('falha_login'))
                        {{ session('falha_login') }}
                    @endif

                    <br>

                    <button>Entrar</button>
                </form>
            </div>
        </div>
    </body>
</html>
