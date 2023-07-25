<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'tb_grupos';

    protected $primaryKey = 'id_grupo';

    protected $fillable = [
        'id_grupo',
        'id_empresa',
        'st_nomeGrupo'
    ];
}
