<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
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

    public function getAll(): Builder
    {
        return DB::table($this->table)
            ->join('especialidade', 'especialidade.id', '=', 'encaminhamento.id_especialidade')
            ->join('status', 'status.id', '=', 'encaminhamento.id_status')
            ->orderBy('data_atualizacao', 'desc');
    }

    public function getAllByMedicoFamilia(int $id_medico_familia): Builder
    {
        return $this->getAll()
            ->where('id_medico_familia', '=', $id_medico_familia);
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
