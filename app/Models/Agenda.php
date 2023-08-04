<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_agenda';

    protected $table = 'tb_agenda';

    protected $fillable = [
        'id_agenda',
        'id_user',
        'st_color',
        'st_dateFinal',
        'st_date',
        'st_titulo',
        'st_descricao',
        'int_tipoData',
    ];
}
