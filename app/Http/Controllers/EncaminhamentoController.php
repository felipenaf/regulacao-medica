<?php

namespace App\Http\Controllers;

use App\Encaminhamento;
use App\EncaminhamentoHistorico;
use App\Especialidade;
use App\MotivoReprovacao;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // $id_medico_familia = $request->session()->get('userData')['id'];
        $id_medico_familia = 1;
        $filtro_nome = '';

        $encaminhamentos = $this->encaminhamento
            ->getAllByMedicoFamilia($id_medico_familia);

        if (!\is_null($request->filtro_nome)) {
            $filtro_nome = $request->filtro_nome;
            $encaminhamentos = $encaminhamentos
                ->where('nome_paciente', 'like', '%' . $request->filtro_nome . '%');
        }

        $encaminhamentos = $encaminhamentos->get([
            "encaminhamento.*",
            DB::raw("CONCAT(SUBSTR(encaminhamento.descricao, 1, 20), ' ...') as descr"),
            "especialidade.nome as especialidade",
            "status.nome as status",
            "motivo_reprovacao.descricao as motivo_reprovacao"
        ]);

        return view('encaminhamento.familia.lista', [
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

        return view('encaminhamento.familia.cadastro', [
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

        return view('encaminhamento.familia.atualizacao', [
            'especialidades' => Especialidade::all()->pluck('nome', 'id'),
            'encaminhamento' => $encaminhamento,
            'motivo_reprovacao' => MotivoReprovacao::all()->pluck('descricao', 'id')
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

        if ($encaminhamento->aprovado()) {
            return response('', \Illuminate\Http\Response::HTTP_FORBIDDEN);
        }

        $encaminhamento->nome_paciente = $request->nome;
        $encaminhamento->cpf_paciente = $request->cpf;
        $encaminhamento->cidade_paciente = $request->cidade;
        $encaminhamento->estado_paciente = $request->estado;
        $encaminhamento->id_especialidade = $request->especialidade;
        $encaminhamento->id_status = Status::PENDENTE;
        $encaminhamento->descricao = $request->descricao;
        $encaminhamento->id_medico_familia = $id_medico_familia;
        $encaminhamento->id_medico_regulador = null;
        $encaminhamento->id_motivo_reprovacao = null;

        $encaminhamento->save();

        $this->encaminhamentoHistorico::create([
            'id_encaminhamento' => $encaminhamento->id,
            'nome_paciente' => $encaminhamento->nome_paciente,
            'cpf_paciente' => $encaminhamento->cpf_paciente,
            'cidade_paciente' => $encaminhamento->cidade_paciente,
            'estado_paciente' => $encaminhamento->estado_paciente,
            'id_especialidade' => $encaminhamento->id_especialidade,
            'id_status' => $encaminhamento->id_status,
            'descricao' => $encaminhamento->descricao,
            'id_medico_familia' => $encaminhamento->id_medico_familia,
        ]);

        return redirect('encaminhamento/sucesso');
    }

    /**
     * Show the form for delete the specified resource
     */
    public function delete(int $id)
    {
        $encaminhamento = $this->encaminhamento->findOrFail($id);

        return view('encaminhamento.familia.remocao', [
            'encaminhamento' => $encaminhamento
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $encaminhamento = $this->encaminhamento->findOrFail($id);

        $encaminhamento->delete();

        return redirect('encaminhamento/sucesso');
    }
}
