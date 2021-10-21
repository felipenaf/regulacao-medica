<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getAllWithRelations()
    {
        return DB::table($this->table)
            ->join('especialidade', 'especialidade.id', '=', 'encaminhamento.id_especialidade')
            ->join('status', 'status.id', '=', 'encaminhamento.id_status')
            ->get(["encaminhamento.*", "especialidade.nome as especialidade", "status.nome as status"]);
    }

    /**
     * Acessor
     */
    public function getCpfPacienteAttribute($value)
    {
        return \str_replace(['.', '-'], '', $value);
    }

    /**
     * Mutator
     */
    public function setCpfPacienteAttribute($value)
    {
        $this->attributes['cpf_paciente'] =
            substr($value, 0, 3) . '.' .
            substr($value, 3, 3) . '.' .
            substr($value, 6, 3) . '-' .
            substr($value, 9, 2);
    }
}
