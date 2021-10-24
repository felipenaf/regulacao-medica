<div class="row">
    @if(Session::exists('userData'))
        <div class="col-9 m-1 links">
            <h5>
                Olá {{ \Illuminate\Support\Facades\Session::get('userData')['nome'] }}
            </h5>
        </div>
        <div class="col links">
            @if(\Illuminate\Support\Facades\Session::get('userData')['perfil'] == \App\PerfilAcesso::MEDICO_FAMILIA)
                <a href="{{ url('/encaminhamento/familia') }}">Home</a>
            @else
                <a href="{{ url('/encaminhamento/regulador') }}">Home</a>
            @endif
        </div>
        <div class="col links">
            <a href="{{ route('logoff') }}">Sair</a>
        </div>
    @endif
</div>
