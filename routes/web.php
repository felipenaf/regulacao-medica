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

Route::post('/encaminhamento', 'EncaminhamentoController@store')
    ->name('registrar_encaminhamento');

Route::get('/encaminhamento/cadastro', 'EncaminhamentoController@create');
Route::get('/encaminhamento/cadastro_sucesso', function () {
    return view('encaminhamento.cadastro_sucesso');
});

Route::get('/encaminhamento', 'EncaminhamentoController@index');
