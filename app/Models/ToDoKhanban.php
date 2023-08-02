<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoKhanban extends Model
{
    use HasFactory;

    protected $table = 'tb_to_do_khanban';
    protected $primaryKey = 'id_toDoKhanban';

    protected $fillable = [
        'id_toDoKhanban',
        'id_columnsKhanban',
        'id_user',
        'st_descricao',
        'int_posicao'
    ];
}
