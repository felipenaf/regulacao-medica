<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref ">
            <div class="">
                <h2 class="m-b-md">
                    Cadastro de Encaminhamento
                </h4>

                <div>
                    <form action="{{ route('registrar_encaminhamento') }}" method="POST">
                        @csrf
                        <label>
                            Nome do Paciente *<br>
                            <input type="text" name="nome" minlength="3" maxlength="255">
                        </label>
                        <br>
                        <label>
                            CPF do Paciente *<br>
                            <input
                                type="text"
                                name="cpf"
                                pattern="[0-9]+"
                                minlength="11"
                                maxlength="11"
                                title="Informe apenas os números"
                                required
                            >
                        </label>
                        <br>
                        <label>
                            Cidade do paciente *<br>
                            <input type="text" name="cidade" minlength="3" maxlength="255" required>
                        </label>
                        <br>
                        <label>
                            Estado do Paciente *<br>
                            <input type="text" name="estado" minlength="2" maxlength="2" required>
                        </label>
                        <br>
                        <label>
                            Especialidades:<br>
                            <select name="especialidade">
                                @forelse ($especialidades as $key => $especialidade)
                                    <option value="{{$key}}">{{$especialidade}}</option>
                                @empty
                                    <option value="0">Cadastre um especialidade</option>
                                @endforelse
                            </select>
                        </label>
                        <br>
                        <label for="">
                            Descrição do problema *<br>
                            <textarea
                                name="descricao"
                                cols="50"
                                rows="10"
                                minlength="10"
                                maxlength="500"
                                required></textarea>
                        </label>
                        <br><br>
                        <input type="hidden" name="status" value="1">
                        <button>Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
