<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('head')

    <body>
        <div class="container">
            @include('menu')

            <div class="content">
                <div class="title m-b-md">
                    Sucesso
                </div>

                <div class="links">
                    <a href="{{ url('encaminhamento/cadastro') }}">Tela de cadastro</a>
                    <a href="{{ url('encaminhamento/familia') }}">Lista de encaminhamentos</a>
                </div>
            </div>
        </div>
    </body>
</html>
