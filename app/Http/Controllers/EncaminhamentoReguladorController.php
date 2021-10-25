<?php

namespace App\Http\Controllers;

use App\Encaminhamento;
use App\EncaminhamentoHistorico;
use App\Especialidade;
use App\MotivoReprovacao;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

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
        $encaminhamentos = $this->encaminhamento->getAll();

        $filtro_status = $request->get('filtro_status');
        if (!\is_null($filtro_status)) {
            $encaminhamentos = $encaminhamentos
                ->where('id_status', '=', $filtro_status);
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

        $request->flashOnly('filtro_status');

        return view('encaminhamento.regulador.lista', [
            'encaminhamentos' => $encaminhamentos,
            'status' => Status::all()->pluck('nome', 'id')->prepend('Todos', '')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $encaminhamento = $this->encaminhamento->getById($id);

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
            'status' => [Rule::in(Status::excetoPendente())],
            'motivo_reprovacao' => 'integer'
        ]);

        $encaminhamento = $this->encaminhamento->findOrFail($id);

        $encaminhamento->id_status = $request->status;
        $encaminhamento->id_medico_regulador = $request->session()->get('userData')['id'];

        if ($request->status == Status::REPROVADO) {
            $encaminhamento->id_motivo_reprovacao = $request->motivo_reprovacao;
        }

        $encaminhamento->save();

        $this->encaminhamentoHistorico::create([
            'id_encaminhamento' => $encaminhamento->id,
            'id_paciente' => $encaminhamento->id_paciente,
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
