<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{

    use HasFactory;
    protected $primaryKey = 'id_venda';
    protected  $table = 'tb_vendas';
    protected $fillable = [
        'int_preco',
        'st_descricao',
        'dt_venda',
        'id_lead'
    ];


    public function produtos()
    {
        return $this->belongsToMany('App\Models\ProdutoServico','tb_venda_produto', 'id_venda', 'id_produtoServico');
    }
}
