<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('head')

    <body>
        <div class="container">
            @include('menu')

            <div class="row">
                <h2>
                    Cadastro de Encaminhamento
                </h2>

                <div class="">
                    <a href="{{url('/encaminhamento/familia')}}">
                        Voltar
                    </a>
                </div>

                <div>
                    <form action="{{ route('registrar_encaminhamento') }}" method="POST">
                        @csrf

                        <label>
                            Paciente:<br>
                            <select id="paciente" name="paciente" required>
                                @forelse ($pacientes as $key => $paciente)
                                    <option value="{{$key}}">{{$paciente}}</option>
                                @empty
                                    <option value="0">Cadastre um paciente</option>
                                @endforelse
                            </select>
                        </label>

                        @error('paciente')
                            <span class="input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label>
                            CPF do Paciente<br>

                            <input type="text" name="cpf" readonly>
                        </label>

                        @error('cpf')
                            <span class="input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label>
                            Cidade do paciente<br>
                            <input type="text" name="cidade" readonly>
                        </label>

                        @error('cidade')
                            <span class="input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label>
                            Estado do Paciente<br>
                            <input type="text" name="estado" readonly>
                        </label>

                        @error('estado')
                            <span class="input-error" role="alert">
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
                            <span class="input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label for="">
                            Descrição do problema *

                            @error('descricao')
                                <span class="input-error" role="alert">
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
                                required
                            ></textarea>
                        </label>
                        <br><br>
                        <input type="hidden" name="status" value="1">
                        <button>Salvar</button>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ \Illuminate\Support\Facades\URL::asset('js/cadastro.js') }}"></script>
    </body>
</html>
