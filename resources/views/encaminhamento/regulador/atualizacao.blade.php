<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('head')

    <body>
        <div class="container">
            <div class="row">
                <h2 class="m-b-md">
                    Atualização de Status
                </h2>

                <a href="{{url('/encaminhamento/regulador')}}">
                    Voltar
                </a>
            </div>

            <div class="row mb-3"></div>

            <div class="row">
                <div class="col">
                    @if($encaminhamento->pendente())
                        <form action="{{ route('atualizar_status_encaminhamento', $encaminhamento->id) }}" method="post">
                            @csrf

                            <label>
                                Status:
                                <select name="status" id="id_status">
                                    @forelse ($status as $key => $value)
                                        <option value="{{$key}}"
                                            @if ($encaminhamento->id_status == $key) selected @endif>
                                            {{$value}}
                                        </option>
                                    @empty
                                        <option value="0">Cadastre um status</option>
                                    @endforelse
                                </select>
                            </label>

                            <br><br>

                            <label id="motivo_reprovacao" style="display:none">
                                Motivo de Reprovação:
                                <select name="motivo_reprovacao">
                                    @forelse ($motivo_reprovacao as $key => $value)
                                        <option value="{{$key}}"
                                                @if ($encaminhamento->id_status == $key) selected @endif>
                                            {{$value}}
                                        </option>
                                    @empty
                                        <option value="0">Cadastre um motivo de reprovação</option>
                                    @endforelse
                                </select>
                            </label>
                            <br><br>
                            <button>Salvar</button>
                        </form>
                    @else
                        <label>
                            Status:
                            <select disabled name="status" id="id_status">
                                @forelse ($status as $key => $value)
                                    <option value="{{$key}}"
                                        @if ($encaminhamento->id_status == $key) selected @endif>
                                        {{$value}}
                                    </option>
                                @empty
                                    <option value="0">Cadastre um status</option>
                                @endforelse
                            </select>
                        </label>

                        <br><br>

                        <label id="motivo_reprovacao" {{--style="display:none"--}}>
                            Motivo de Reprovação:
                            <select disabled name="motivo_reprovacao">
                                @forelse ($motivo_reprovacao as $key => $value)
                                    <option value="{{$key}}"
                                            @if ($encaminhamento->id_status == $key) selected @endif>
                                        {{$value}}
                                    </option>
                                @empty
                                    <option value="0">Cadastre um motivo de reprovação</option>
                                @endforelse
                            </select>
                        </label>
                        <br><br>
                    @endif
                </div>

                <br>

                <div class="col">
                    <label>
                        Nome do Paciente <br>
                        <input disabled value="{{$encaminhamento->nome_paciente}}" type="text">
                    </label>

                    <br>
                    <label>
                        CPF do Paciente <br>
                        <input disabled value="{{$encaminhamento->cpf_paciente}}" type="text">
                    </label>

                    <br>
                    <label>
                        Cidade do paciente <br>
                        <input disabled value="{{$encaminhamento->cidade_paciente}}" type="text">
                    </label>

                    <br>
                    <label>
                        Estado do Paciente <br>
                        <input disabled value="{{$encaminhamento->estado_paciente}}" type="text">
                    </label>

                    <br>
                    <label>
                        Especialidade:<br>
                        <select disabled name="especialidade">
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

                    <br>
                    <label for="">
                        Descrição do problema
                        <br>
                        <textarea
                            disabled
                            cols="50"
                            rows="10"
                            >{{$encaminhamento->descricao}}</textarea>
                    </label>
                </div>
            </div>
        </div>

        <script src="{{ \Illuminate\Support\Facades\URL::asset('js/script.js') }}"></script>
        {{--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>--}}
    </body>
</html>
