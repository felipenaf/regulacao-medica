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
    private $encaminhamento;

    public function __construct(Encaminhamento $encaminhamento)
    {
        $this->encaminhamento = $encaminhamento;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('encaminhamento.lista', [
            'encaminhamentos' => $this->encaminhamento->getAllWithRelations()
        ]);
    }

    /**
     * Show the form for creating a new resource.
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
     */
    public function store(Request $request)
    {
        $id_medico_familia = 1;

        $data = Encaminhamento::create([
            'nome_paciente' => $request->nome,
            'cpf_paciente' => $request->cpf,
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
            'cpf_paciente' => $request->cpf,
            'cidade_paciente' => $request->cidade,
            'estado_paciente' => $request->estado,
            'id_especialidade' => $request->especialidade,
            'id_status' => $request->status,
            'descricao' => $request->descricao,
            'id_medico_familia' => $id_medico_familia,
        ]);

        return redirect('encaminhamento/sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Encaminhamento $encaminhamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $encaminhamento = $this->encaminhamento->findOrFail($id);

        return view('encaminhamento.atualizacao', [
            'especialidades' => Especialidade::all()->pluck('nome', 'id'),
            'encaminhamento' => $encaminhamento
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $id_medico_familia = 1;

        $encaminhamento = $this->encaminhamento->findOrFail($id);

        $encaminhamento->nome_paciente = $request->nome;
        $encaminhamento->cpf_paciente = $request->cpf;
        $encaminhamento->cidade_paciente = $request->cidade;
        $encaminhamento->estado_paciente = $request->estado;
        $encaminhamento->id_especialidade = $request->especialidade;
        $encaminhamento->id_status = $request->status;
        $encaminhamento->descricao = $request->descricao;
        $encaminhamento->id_medico_familia = $id_medico_familia;

        $encaminhamento->save();

        return redirect('encaminhamento/sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Encaminhamento $encaminhamento)
    {
        //
    }
}
