<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EncaminhamentoHistorico extends Model
{
    protected $table = 'encaminhamento_historico';

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_encaminhamento',
        'nome_paciente',
        'cpf_paciente',
        'cidade_paciente',
        'estado_paciente',
        'id_especialidade',
        'id_status',
        'descricao',
        'id_medico_familia',
        'id_medico_regulador',
        'id_motivo_reprovacao',
    ];
}
