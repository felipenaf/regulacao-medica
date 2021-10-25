<?php

namespace App\Http\Controllers;

use App\Encaminhamento;
use App\EncaminhamentoHistorico;
use App\Especialidade;
use App\MotivoReprovacao;
use App\Paciente;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

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
        $encaminhamentos = $this->encaminhamento
            ->getAllByMedicoFamilia($request->session()->get('userData')['id']);

        $filtro_nome = $request->get('filtro_nome');
        if (!\is_null($filtro_nome)) {
            $encaminhamentos = $encaminhamentos
                ->where('paciente.nome', 'like', '%' . $filtro_nome . '%');
        }

        $encaminhamentos = $encaminhamentos->get([
            "encaminhamento.*",
            "paciente.nome as nome_paciente",
            "paciente.cpf as cpf_paciente",
            "cidade.nome as cidade_paciente",
            "estado.nome as estado_paciente",
            DB::raw("CONCAT(SUBSTR(encaminhamento.descricao, 1, 20), ' ...') as descr"),
            "especialidade.nome as especialidade",
            "status.nome as status",
            "motivo_reprovacao.descricao as motivo_reprovacao"
        ]);

        $request->flashOnly('filtro_nome');

        return view('encaminhamento.familia.lista', [
            'encaminhamentos' => $encaminhamentos,
            'filtro_nome' => $filtro_nome
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('encaminhamento.familia.cadastro', [
            'especialidades' => Especialidade::all()->pluck('nome', 'id'),
            'pacientes' => Paciente::all()->pluck('nome', 'id')->prepend('Escolha um paciente', '')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'paciente' => Rule::in(Paciente::all()->pluck('id')->toArray()),
            'especialidade' => 'required|integer',
            'status' => 'required|integer',
            'descricao' => 'required|max:500'
        ]);

        $data = $this->encaminhamento::create([
            'id_paciente' => $request->paciente,
            'id_especialidade' => $request->especialidade,
            'id_status' => $request->status,
            'descricao' => $request->descricao,
            'id_medico_familia' => $request->session()->get('userData')['id'],
        ]);

        $this->encaminhamentoHistorico::create([
            'id_encaminhamento' => $data->id,
            'id_paciente' => $data->id_paciente,
            'id_especialidade' => $data->id_especialidade,
            'id_status' => $data->id_status,
            'descricao' => $data->descricao,
            'id_medico_familia' => $data->id_medico_familia,
        ]);

        return redirect('encaminhamento/sucesso');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $encaminhamento = $this->encaminhamento->getById($id);

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
        $this->validate($request, [
            'especialidade' => Rule::in(Especialidade::all()->pluck('id')),
            'descricao' => 'required|max:500'
        ]);

        $encaminhamento = $this->encaminhamento->findOrFail($id);

        if ($encaminhamento->aprovado()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $encaminhamento->id_especialidade = $request->especialidade;
        $encaminhamento->id_status = Status::PENDENTE;
        $encaminhamento->descricao = $request->descricao;
        $encaminhamento->id_medico_familia = $request->session()->get('userData')['id'];
        $encaminhamento->id_medico_regulador = null;
        $encaminhamento->id_motivo_reprovacao = null;

        $encaminhamento->save();

        $this->encaminhamentoHistorico::create([
            'id_encaminhamento' => $encaminhamento->id,
            'id_paciente' => $encaminhamento->id_paciente,
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
        return view('encaminhamento.familia.remocao', [
            'encaminhamento' => $this->encaminhamento->getById($id)
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
