<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColumnsKhanban extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_columnsKhanban';

    protected $table = 'tb_columns_khanban';

    protected $fillable = [
        'id_columnsKhanban',
        'id_empresa',
        'st_titulo',
        'st_color',
        'int_posicao',
        'int_tipoKhanban'
    ];
}
