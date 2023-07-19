<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperatura extends Model
{
    use HasFactory;

    protected $table = 'tb_temperaturas';
    protected $fillable = [
        'id_temperatura',
        'id_empresa',
        'st_nomeTemperatura'
    ];
}
