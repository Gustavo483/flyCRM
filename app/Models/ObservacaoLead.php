<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacaoLead extends Model
{
    use HasFactory;
    protected $table = 'tb_observacoes_leads';
    protected $fillable = [
        'id_observacao',
        'id_lead',
        'bl_oportunidade',
        'dt_contato',
        'st_titulo',
        'st_descricao',
        'id_empresa'
    ];
    public function lead()
    {
        return $this->hasOne('App\Models\Lead','id_lead', 'id_lead');
    }
}
