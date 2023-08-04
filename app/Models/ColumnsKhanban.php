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
    public function leads()
    {
        return $this->hasMany('App\Models\Lead','id_columnsKhanban', 'id_columnsKhanban')->orderBy('int_posicao');
    }
    public function leadsKanbanStatus()
    {
        return $this->hasMany('App\Models\Lead','id_columnsKhanban', 'id_columnsKhanban')->orderBy('int_posicao')->limit(4);
    }

    public function ToDoUser(){
        return $this->hasMany('App\Models\ToDoKhanban','id_columnsKhanban', 'id_columnsKhanban')->where('id_user',auth()->user()->id)->where('bl_ativo',1);
    }
}
