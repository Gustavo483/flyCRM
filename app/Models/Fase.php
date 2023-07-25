<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    use HasFactory;

    protected $table = 'tb_fases';

    protected $primaryKey = 'id_fase';

    protected $fillable = [
        'id_fase',
        'id_empresa',
        'st_nomeFase'
    ];
}
