<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ \Illuminate\Support\Facades\URL::asset('css/style.css') }}">
    </head>
    <body>
        <div class="m-l-md position-ref">
            <div class="">
                <h2 class="m-b-md">
                    Apagar registro
                </h2>

                <div>
                    <form action="{{ route('apagar_encaminhamento', $encaminhamento->id) }}" method="post">
                        @csrf
                        <a href="{{url('/encaminhamento/familia')}}"> Voltar </a>

                        <div>
                            Tem certeza que deseja remover o encaminhamento do paciente: {{ $encaminhamento->nome_paciente }} ?
                        </div>

                        <button>Sim</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
