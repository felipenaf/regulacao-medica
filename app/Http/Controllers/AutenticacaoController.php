<?php

namespace App\Http\Controllers;

use App\PerfilAcesso;
use App\Usuario;
use Illuminate\Http\Request;

class AutenticacaoController extends Controller
{
    public function index(Request $request)
    {
        return view('autenticacao.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|max:255|email',
            'senha' => 'required|max:255',
        ]);

        $user = Usuario::query()
            ->where('email', '=', $request->email)
            ->where('senha', '=', $request->senha)
            ->first();

        if ($user->doesntExist()) {
            $request->session()->flash('falha_login', 'Login ou senha inválidos');
            $request->session()->flash('email', $request->email);

            return redirect('/login');
        }

        $request->session()->put('userData', [
            'id' => $user->id,
            'perfil' => $user->id_perfil_acesso,
            'nome' => $user->nome
        ]);

        if ($user->id_perfil_acesso == PerfilAcesso::MEDICO_FAMILIA) {
            return redirect('/encaminhamento/familia');
        }

        return redirect('/encaminhamento/regulador');
    }
}