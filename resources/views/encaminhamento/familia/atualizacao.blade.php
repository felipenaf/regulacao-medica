<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('head')

    <body>
        <div class="container">
            @include('menu')

            <div class="row">
                <h2 class="m-b-md">
                    Atualização de Encaminhamento
                </h2>

                <div class="">
                    <a href="{{url('/encaminhamento/familia')}}">
                        Voltar
                    </a>
                </div>

                @if($encaminhamento->reprovado())
                    <div>
                        <p>
                            <b>Status: </b>
                            <span class="input-error">
                                {{ \App\Status::$text[\App\Status::REPROVADO] }}
                            </span>
                        </p>
                        <p>
                            <b>Motivo da reprovação: </b>
                            <span class="input-error">
                                {{ $motivo_reprovacao[$encaminhamento->id_motivo_reprovacao] }}
                            </span>
                        </p>
                    </div>
                @endif

                <div>
                    <form action="{{ route('atualizar_encaminhamento', $encaminhamento->id) }}" method="post">
                        @csrf

                        <label>
                            Nome do Paciente *<br>
                            <input value="{{$encaminhamento->nome_paciente}}" type="text" name="nome" minlength="3" maxlength="255">
                        </label>

                        @error('nome')
                            <span class="input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label>
                            CPF do Paciente *<br>
                            <input value="{{$encaminhamento->cpf_paciente}}"
                                type="text"
                                name="cpf"
                                pattern="[0-9]+"
                                minlength="11"
                                maxlength="11"
                                title="Informe apenas os números"
                                required
                            >
                        </label>

                        @error('cpf')
                            <span class="input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label>
                            Cidade do paciente *<br>
                            <input value="{{$encaminhamento->cidade_paciente}}" type="text" name="cidade" minlength="3" maxlength="255" required>
                        </label>

                        @error('cidade')
                            <span class="input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <br>
                        <label>
                            Estado do Paciente *<br>
                            <input value="{{$encaminhamento->estado_paciente}}" type="text" name="estado" minlength="2" maxlength="2" required>
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
                                    <option value="{{$key}}"
                                        @if ($encaminhamento->id_especialidade == $key) selected @endif>
                                        {{$especialidade}}
                                    </option>
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
                                required>{{$encaminhamento->descricao}}</textarea>
                        </label>
                        <br><br>
                        <input value="{{$encaminhamento->id_status}}" type="hidden" name="status">
                        <button>Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
