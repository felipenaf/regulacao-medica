<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encaminhamento extends Model
{
    protected $table = 'encaminhamento';

    const CREATED_AT = 'data_criacao';
    const UPDATED_AT = 'data_atualizacao';

    protected $fillable = [
        'nome_paciente',
        'cpf_paciente',
        'cidade_paciente',
        'estado_paciente',
        'id_especialidade',
        'id_status',
        'descricao',
        'id_medico_familia',
    ];
}
