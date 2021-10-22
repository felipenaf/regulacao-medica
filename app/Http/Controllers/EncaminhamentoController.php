<?php

namespace App\Http\Controllers;

use App\Encaminhamento;
use App\EncaminhamentoHistorico;
use App\Especialidade;
use Illuminate\Http\Request;

class EncaminhamentoController extends Controller
{
    private $encaminhamento;
    private $encaminhamentoHistorico;

    public function __construct(
        Encaminhamento $encaminhamento,
        EncaminhamentoHistorico $encaminhamentoHistorico
    ) {
        $this->encaminhamento = $encaminhamento;
        $this->encaminhamentoHistorico = $encaminhamentoHistorico;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //TODO: Pegar da sessão
        $id_medico_familia = 1;
        $filtro_nome = '';

        $encaminhamentos = $this->encaminhamento
            ->getAllWithRelations($id_medico_familia);

        if (!\is_null($request->filtro_nome)) {
            $filtro_nome = $request->filtro_nome;
            $encaminhamentos = $encaminhamentos
                ->where('nome_paciente', 'like', '%' . $request->filtro_nome . '%');
        }

        $encaminhamentos = $encaminhamentos->get([
            "encaminhamento.*",
            "especialidade.nome as especialidade",
            "status.nome as status"
        ]);

        return view('encaminhamento.lista', [
            'encaminhamentos' => $encaminhamentos,
            'filtro_nome' => $filtro_nome
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
        // TODO: colocar sessão
        $id_medico_familia = 1;

        $this->validate($request, [
            'nome' => 'required|max:255',
            'cpf' => 'required|max:11|regex:/[0-9]+/',
            'cidade' => 'required|max:255',
            'estado' => 'required|max:2',
            'especialidade' => 'required|integer',
            'status' => 'required|integer',
            'descricao' => 'required|max:500'
        ]);

        $data = $this->encaminhamento::create([
            'nome_paciente' => $request->nome,
            'cpf_paciente' => $request->cpf,
            'cidade_paciente' => $request->cidade,
            'estado_paciente' => $request->estado,
            'id_especialidade' => $request->especialidade,
            'id_status' => $request->status,
            'descricao' => $request->descricao,
            'id_medico_familia' => $id_medico_familia,
        ]);

        $this->encaminhamentoHistorico::create([
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

        $this->validate($request, [
            'nome' => 'required|max:255',
            'cpf' => 'required|max:11|regex:/[0-9]+/',
            'cidade' => 'required|max:255',
            'estado' => 'required|max:2',
            'especialidade' => 'required|integer',
            'status' => 'required|integer',
            'descricao' => 'required|max:500'
        ]);

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
