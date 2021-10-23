<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('encaminhamento.head')

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
                <br>
                <div class="">
                    <form action="{{route('filtro_status')}}" method="get">
                        <label for="filtro_status">
                            Filtrar por status
                            <input type="text" name="filtro_status" value="{{ $filtro_status }}">
                        </label>
                        <button>Pesquisar</button>
                    </form>
                </div>
                <br>
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
                                        <i class="fa fa-pencil" title="Detalhes">edit</i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <p>Nenhum resgistro encontrado</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
