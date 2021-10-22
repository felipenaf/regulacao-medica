<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/encaminhamento/familia', 'EncaminhamentoController@getAllFamilia')->name('filtro_nome');
Route::get('/encaminhamento/regulador', 'EncaminhamentoController@getAllRegulador')->name('filtro_status');
Route::get('/encaminhamento/cadastro', 'EncaminhamentoController@create');
Route::get('/encaminhamento/edit/{id}', 'EncaminhamentoController@edit');
Route::get('/encaminhamento/delete/{id}', 'EncaminhamentoController@delete');

Route::post('/encaminhamento', 'EncaminhamentoController@store')
    ->name('registrar_encaminhamento');
Route::post('/encaminhamento/edit/{id}', 'EncaminhamentoController@update')
    ->name('atualizar_encaminhamento');
Route::post('/encaminhamento/delete/{id}', 'EncaminhamentoController@destroy')
    ->name('apagar_encaminhamento');

Route::get('/encaminhamento/sucesso', function () {
    return view('encaminhamento.sucesso');
});
