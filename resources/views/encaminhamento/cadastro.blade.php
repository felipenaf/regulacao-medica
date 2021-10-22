<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ \Illuminate\Support\Facades\URL::asset('css/style.css') }}">
    </head>
    <body>
        <div class="m-l-md position-ref ">
            <div class="">
                <div>
                    <h2>
                        Cadastro de Encaminhamento
                    </h2>
                </div>

                <div class="">
                    <a href="{{url('/encaminhamento')}}">
                        Voltar
                    </a>
                </div>

                <div>
                    <form action="{{ route('registrar_encaminhamento') }}" method="POST">
                        @csrf

                        <label>
                            Nome do Paciente *<br>
                            <input
                                type="text"
                                name="nome"
                                minlength="3"
                                maxlength="255"
                                value="{{ old('nome') }}"

                            >
                        </label>

                        @error('nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label>
                            CPF do Paciente *<br>

                            <input
                                type="text"
                                name="cpf"
                                pattern="[0-9]+"
                                minlength="11"
                                maxlength="11"
                                title="Informe apenas os números"
                                value="{{ old('cpf') }}"

                            >
                        </label>

                        @error('cpf')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label>
                            Cidade do paciente *<br>
                            <input type="text" name="cidade" minlength="3" maxlength="255" value="{{ old('cidade') }}" >
                        </label>

                        @error('cidade')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label>
                            Estado do Paciente *<br>
                            <input type="text" name="estado" minlength="2" maxlength="2" value="{{ old('estado') }}" >
                        </label>

                        @error('estado')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label>
                            Especialidades:<br>
                            <select name="especialidade">
                                @forelse ($especialidades as $key => $especialidade)
                                    <option value="{{$key}}">{{$especialidade}}</option>
                                @empty
                                    <option value="0">Cadastre um especialidade</option>
                                @endforelse
                            </select>
                        </label>

                        @error('especialidade')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label for="">
                            Descrição do problema *

                            @error('descricao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <br>
                            <textarea
                                name="descricao"
                                cols="50"
                                rows="10"
                                minlength="10"
                                maxlength="500"
                                value="{{ old('nome') }}"

                                ></textarea>
                        </label>
                        <br><br>
                        <input type="hidden" name="status" value="1">
                        <button>Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
