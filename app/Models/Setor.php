<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    use HasFactory;
    protected $table = 'tb_setores';

    protected $primaryKey = 'id_setor';

    protected $fillable = [
        'id_setor',
        'id_empresa',
        'st_nomeSetor'
    ];
}
