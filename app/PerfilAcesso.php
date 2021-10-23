<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfilAcesso extends Model
{
    protected $table = 'perfil_acesso';

    public const MEDICO_FAMILIA = 1;
    public const MEDICO_REGULADOR = 2;
}
