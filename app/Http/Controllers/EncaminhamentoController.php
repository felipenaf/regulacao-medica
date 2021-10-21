<?php

namespace App\Http\Controllers;

use App\Encaminhamento;
use App\EncaminhamentoHistorico;
use App\Especialidade;
use App\Paciente;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EncaminhamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('encaminhamento.lista');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        // $dados_sessao = $request->session()->all();

        return view('encaminhamento.cadastro', [
            'especialidades' => Especialidade::all()->pluck('nome', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cpf_formatado =
            substr($request->cpf, 0, 3) . '.' .
            substr($request->cpf, 3, 3) . '.' .
            substr($request->cpf, 6, 3) . '-' .
            substr($request->cpf, 9, 2);

        $id_medico_familia = 1;

        $data = Encaminhamento::create([
            'nome_paciente' => $request->nome,
            'cpf_paciente' => $cpf_formatado,
            'cidade_paciente' => $request->cidade,
            'estado_paciente' => $request->estado,
            'id_especialidade' => $request->especialidade,
            'id_status' => $request->status,
            'descricao' => $request->descricao,
            'id_medico_familia' => $id_medico_familia,
        ]);

        EncaminhamentoHistorico::create([
            'id_encaminhamento' => $data->id,
            'nome_paciente' => $request->nome,
            'cpf_paciente' => $cpf_formatado,
            'cidade_paciente' => $request->cidade,
            'estado_paciente' => $request->estado,
            'id_especialidade' => $request->especialidade,
            'id_status' => $request->status,
            'descricao' => $request->descricao,
            'id_medico_familia' => $id_medico_familia,
        ]);

        return redirect('encaminhamento/cadastro_sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Encaminhamento  $encaminhamento
     * @return \Illuminate\Http\Response
     */
    public function show(Encaminhamento $encaminhamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Encaminhamento  $encaminhamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Encaminhamento $encaminhamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Encaminhamento  $encaminhamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Encaminhamento $encaminhamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encaminhamento  $encaminhamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Encaminhamento $encaminhamento)
    {
        //
    }
}
