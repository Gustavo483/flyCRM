<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origem extends Model
{
    use HasFactory;
    protected $table = 'tb_origens';

    protected $primaryKey = 'id_origem';

    protected $fillable = [
        'id_origem',
        'id_empresa',
        'st_nomeOrigem'
    ];
}
