<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'tb_leads';
    protected $primaryKey = 'id_lead';

    protected $fillable = [
        'id_lead',
        'st_nome',
        'int_telefone',
        'int_posicao',
        'st_email',
        'id_origem',
        'id_midia',
        'id_campanha',
        'id_produtoServico',
        'id_fase',
        'int_temperatura',
        'id_grupo',
        'st_observacoes',
        'id_userResponsavel',
        'id_columnsKhanban',
        'id_empresa'
    ];

    public function observacoes(){
        return $this->hasMany('App\Models\ObservacaoLead','id_lead', 'id_lead');
    }
    public function fase(){
        return $this->hasOne('App\Models\Fase','id_fase', 'id_fase');
    }
    public function produto(){
        return $this->hasOne('App\Models\ProdutoServico','id_produtoServico', 'id_produtoServico');
    }
}
