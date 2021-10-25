<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('head')

    <body>
        <div class="container">
            @include('menu')

            <div class="row">
                <h2>
                    Encaminhamentos
                </h2>

                <div class="mb-4">
                    <a href="{{url('/encaminhamento/cadastro')}}">
                        Cadastrar novo encaminhamento
                    </a>
                </div>

                @if($encaminhamentos->isNotEmpty())
                    <div class="mb-4">
                        <form action="{{route('filtro_nome')}}" method="get">
                            <label for="filtro_nome">
                                Filtrar por nome
                                <input type="text" name="filtro_nome" value="{{ old('filtro_nome') }}">
                            </label>
                            <button>Pesquisar</button>
                        </form>
                    </div>
                @endif

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
                                <td
                                    @if($encaminhamento->id_status == \App\Status::REPROVADO)
                                        title="{{ $encaminhamento->motivo_reprovacao }}"
                                    @endif
                                >{{$encaminhamento->status}}</td>
                                <td>{{$encaminhamento->especialidade}}</td>
                                <td title="{{$encaminhamento->descricao}}">{{$encaminhamento->descr}}</td>
                                <td>{{$encaminhamento->data_atualizacao}}</td>
                                <td>
                                    @if($encaminhamento->id_status != \App\Status::APROVADO)
                                        <a href="{{url('/encaminhamento/familia/edit', $encaminhamento->id)}}">
                                            <i class="fa fa-pencil" title="Editar"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('/encaminhamento/delete', $encaminhamento->id)}}">
                                        <i class="fa fa-trash" title="Apagar"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <p>Nenhum resgistro encantrado</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
