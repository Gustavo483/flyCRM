<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campanha extends Model
{
    use HasFactory;

    protected $table = 'tb_campanhas';

    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        'id_campanha',
        'id_empresa',
        'st_nomeCampanha'
    ];
}
