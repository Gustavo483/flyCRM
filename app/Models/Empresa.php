<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'tb_empresas';

    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        'id_empresa',
        'st_nomeEmpresa',
        'st_DocResponsavel',
        'st_telefone',
        'id_plano',
        'st_periodicidade',
        'st_descricao',
        'bl_ativo',
        'id_user',
        'dt_validade',
    ];
}
