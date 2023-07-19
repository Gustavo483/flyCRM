<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midia extends Model
{
    use HasFactory;

    protected $table = 'tb_midias';
    protected $fillable = [
        'id_midia',
        'id_empresa',
        'st_nomeMidia'
    ];
}
