<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ \Illuminate\Support\Facades\URL::asset('css/style.css') }}">
    </head>
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
                                <td>{{$encaminhamento->status}}</td>
                                <td>{{$encaminhamento->especialidade}}</td>
                                <td title="{{$encaminhamento->descricao}}">{{$encaminhamento->descr}}</td>
                                <td>{{$encaminhamento->data_atualizacao}}</td>
                                <td>
                                    <a href="{{url('/encaminhamento/edit', $encaminhamento->id)}}">
                                        <i class="fa fa-pencil" title="Editar"></i>
                                    </a>
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
