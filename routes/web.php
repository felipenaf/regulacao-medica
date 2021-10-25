<?php

use App\PerfilAcesso;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Colocar essa função em um middleware e passar nos controllers devidos
 */
Route::get('/paciente/{id}', function (int $id) {
    $paciente = \App\Paciente::query()
        ->where('paciente.id', '=', $id)
        ->join('cidade', 'cidade.id', '=', 'paciente.id_cidade')
        ->join('estado', 'estado.id', '=', 'cidade.id_estado')
        ->get(['paciente.*', 'cidade.nome as cidade', 'estado.nome as estado'])
        ->first();

    return response([
        'paciente' => $paciente
    ]);
})->name('paciente');

Route::get('/', function () {
    if (!Session::exists('userData')) {
        return redirect('/login');
    }

    if (Session::get('userData')['perfil'] == PerfilAcesso::MEDICO_FAMILIA) {
        return redirect('/encaminhamento/familia');
    }

    return redirect('/encaminhamento/regulador');
    // return view('welcome');
});

Route::get('/login', 'AutenticacaoController@index')->name('login');
Route::get('/logoff', 'AutenticacaoController@destroy')->name('logoff');
Route::post('/login', 'AutenticacaoController@login')->name('autenticacao');

Route::middleware(['auth.session'])->group(function () {
    Route::middleware('auth.session.familia')->group(function () {
        Route::get('/encaminhamento/familia', 'EncaminhamentoController@index')->name('filtro_nome');
        Route::get('/encaminhamento/familia/edit/{id}', 'EncaminhamentoController@edit');
        Route::get('/encaminhamento/cadastro', 'EncaminhamentoController@create');
        Route::get('/encaminhamento/delete/{id}', 'EncaminhamentoController@delete');
        Route::post('/encaminhamento', 'EncaminhamentoController@store')
            ->name('registrar_encaminhamento');
        Route::post('/encaminhamento/edit/{id}', 'EncaminhamentoController@update')
            ->name('atualizar_encaminhamento');
        Route::post('/encaminhamento/delete/{id}', 'EncaminhamentoController@destroy')
            ->name('apagar_encaminhamento');
        Route::get('/encaminhamento/sucesso', function () {
            return view('encaminhamento.familia.sucesso');
        });
    });

    Route::middleware(['auth.session.regulador'])->group(function () {
        Route::get('/encaminhamento/regulador', 'EncaminhamentoReguladorController@index')->name('filtro_status');
        Route::get('/encaminhamento/regulador/edit/{id}', 'EncaminhamentoReguladorController@edit');
        Route::post('/encaminhamento/regulador/edit/{id}', 'EncaminhamentoReguladorController@update')
            ->name('atualizar_status_encaminhamento');
        Route::get('/encaminhamento/regulador/sucesso', function () {
            return view('encaminhamento.regulador.sucesso');
        });
    });
});
