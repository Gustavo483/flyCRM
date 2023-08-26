<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoServico extends Model
{
    use HasFactory;
    protected $table = 'tb_produto_servicos';

    protected $primaryKey = 'id_produtoServico';

    protected $fillable = [
        'id_produtoServico',
        'id_empresa',
        'st_nomeProdutoServico',
        'st_color',
        'st_descricao'
    ];

    public function leads(){
        return $this->hasMany('App\Models\Lead','id_produtoServico', 'id_produtoServico');
    }
    public function venda()
    {
        return $this->belongsToMany(Venda::class, 'tb_venda_produto');
    }
}
