<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    public const PENDENTE = 1;
    public const APROVADO = 2;
    public const REPROVADO = 3;

    public static $text = [
        self::PENDENTE => 'Pendente',
        self::APROVADO => 'Aprovado',
        self::REPROVADO => 'Reprovado'
    ];

    public static function excetoPendente(): array
    {
        return [
            Status::APROVADO,
            Status::REPROVADO,
        ];
    }
}
