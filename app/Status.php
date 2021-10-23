<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    public const PENDENTE = 1;
    public const APROVADO = 2;
    public const REPROVADO = 3;
}
