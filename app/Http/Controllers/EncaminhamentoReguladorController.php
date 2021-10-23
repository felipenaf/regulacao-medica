<?php

namespace App\Http\Controllers;

use App\Encaminhamento;
use App\EncaminhamentoHistorico;
use App\Especialidade;
use App\MotivoReprovacao;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncaminhamentoReguladorController extends Controller
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
        $filtro_status = '';

        $encaminhamentos = $this->encaminhamento->getAll();

        if (!\is_null($request->filtro_status)) {
            $filtro_status = $request->filtro_status;
            $encaminhamentos = $encaminhamentos
                ->where('id_status', '=', $request->filtro_status);
        }

        $encaminhamentos = $encaminhamentos->get([
            "encaminhamento.*",
            DB::raw("CONCAT(SUBSTR(encaminhamento.descricao, 1, 20), ' ...') as descr"),
            "especialidade.nome as especialidade",
            "status.nome as status"
        ]);

        return view('encaminhamento.regulador.lista', [
            'encaminhamentos' => $encaminhamentos,
            'filtro_status' => $filtro_status
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $encaminhamento = $this->encaminhamento->findOrFail($id);

        return view('encaminhamento.regulador.atualizacao', [
            'motivo_reprovacao' => MotivoReprovacao::all()->pluck('descricao', 'id'),
            'status' => Status::all()->pluck('nome', 'id'),
            'especialidades' => Especialidade::find($encaminhamento->id_especialidade)->pluck('nome', 'id'),
            'encaminhamento' => $encaminhamento
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer',
            'motivo_reprovacao' => 'integer'
        ]);

        // TODO: pegar da sessão
        $id_medico_regulador = 2;

        $encaminhamento = $this->encaminhamento->findOrFail($id);

        if (!$encaminhamento->pendente()) {
            return response('', \Illuminate\Http\Response::HTTP_FORBIDDEN);
        }

        $encaminhamento->id_status = $request->status;
        $encaminhamento->id_medico_regulador = $id_medico_regulador;

        if ($request->status == Status::REPROVADO) {
            $encaminhamento->id_motivo_reprovacao = $request->motivo_reprovacao;
        }

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
            'id_medico_regulador' => $encaminhamento->id_medico_regulador,
            'id_motivo_reprovacao' => $encaminhamento->id_motivo_reprovacao,
        ]);

        return redirect('encaminhamento/regulador/sucesso');
    }
}
