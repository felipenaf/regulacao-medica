<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'AutenticacaoController@index')->name('login');
Route::post('/login', 'AutenticacaoController@login')->name('autenticacao');

Route::get('/encaminhamento/familia', 'EncaminhamentoController@index')->name('filtro_nome');
    // ->middleware('AuthSession');
Route::get('/encaminhamento/regulador', 'EncaminhamentoReguladorController@index')->name('filtro_status');

Route::get('/encaminhamento/cadastro', 'EncaminhamentoController@create');

Route::get('/encaminhamento/familia/edit/{id}', 'EncaminhamentoController@edit');
Route::get('/encaminhamento/regulador/edit/{id}', 'EncaminhamentoReguladorController@edit');

Route::get('/encaminhamento/delete/{id}', 'EncaminhamentoController@delete');

Route::post('/encaminhamento', 'EncaminhamentoController@store')
    ->name('registrar_encaminhamento');

Route::post('/encaminhamento/edit/{id}', 'EncaminhamentoController@update')
    ->name('atualizar_encaminhamento');
Route::post('/encaminhamento/regulador/edit/{id}', 'EncaminhamentoReguladorController@update')
    ->name('atualizar_status_encaminhamento');

Route::post('/encaminhamento/delete/{id}', 'EncaminhamentoController@destroy')
    ->name('apagar_encaminhamento');

Route::get('/encaminhamento/sucesso', function () {
    return view('encaminhamento.familia.sucesso');
});

Route::get('/encaminhamento/regulador/sucesso', function () {
    return view('encaminhamento.regulador.sucesso');
});
