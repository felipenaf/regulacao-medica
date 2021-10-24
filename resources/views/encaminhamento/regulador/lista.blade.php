<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('head')

    <body>
        <div class="container">
            @include('menu')

            <div class="row">
                <h2>Encaminhamentos</h2>
            </div>

            <br>
            <div class="row">
                <form action="{{route('filtro_status')}}" method="get">
                    <label for="filtro_status">
                        Filtrar por status
                        <select name="filtro_status">
                            @foreach($status as $key => $value)
                                <option value="{{$key}}"
                                    @if (old('filtro_status') == $key) selected @endif>
                                    {{$value}}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <button>Pesquisar</button>
                </form>
            </div>
            <br>
            <table class="table">
                @if($encaminhamentos->isNotEmpty())
                <thead>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Status</th>
                    <th>Especialidade</th>
                    <th>Descrição</th>
                    <th>Data/Hora de modificação</th>
                    <th>Detalhes</th>
                </thead>
                @endif
                <tbody>
                    @forelse($encaminhamentos as $encaminhamento)
                        <tr>
                            <td>{{$encaminhamento->nome_paciente}}</td>
                            <td>{{$encaminhamento->cpf_paciente}}</td>
                            <td>{{$encaminhamento->cidade_paciente}}</td>
                            <td>{{$encaminhamento->estado_paciente}}</td>
                            <td>{{$encaminhamento->status}}</td>
                            <td>{{$encaminhamento->especialidade}}</td>
                            <td title="{{$encaminhamento->descricao}}">{{$encaminhamento->descr}}</td>
                            <td>{{$encaminhamento->data_atualizacao}}</td>
                            <td>
                                <a href="{{url('/encaminhamento/regulador/edit', $encaminhamento->id)}}">
                                    <i class="fa fa-pencil" title="Detalhes"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <p>Nenhum resgistro encontrado</p>
                    @endforelse
                </tbody>
            </table>
        </div>
    </body>
</html>
