<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('encaminhamento.head')

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
