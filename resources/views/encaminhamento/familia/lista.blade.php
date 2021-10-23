<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('head')

    <body>
        <div class="position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="m-l-md position-ref">
                <div>
                    <h2>Encaminhamentos</h2>
                </div>
                <div class="">
                    <a href="{{url('/encaminhamento/cadastro')}}">
                        Cadastrar novo encaminhamento
                    </a>
                </div>
                <br>
                <div class="">
                    <form action="{{route('filtro_nome')}}" method="get">
                        <label for="filtro_nome">
                            Filtrar por nome
                            <input type="text" name="filtro_nome" value="{{ $filtro_nome }}">
                        </label>
                        <button>Pesquisar</button>
                    </form>
                </div>
                <table class="content">
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
                        <th></th>
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
                                            <i class="fa fa-pencil" title="Editar">e</i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('/encaminhamento/delete', $encaminhamento->id)}}">
                                        <i class="fa fa-trash" title="Apagar">e</i>
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
