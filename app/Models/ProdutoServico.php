<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoServico extends Model
{
    use HasFactory;
    protected $table = 'tb_produto_servicos';
    protected $fillable = [
        'id_produtoServico',
        'id_empresa',
        'st_nomeProdutoServico'
    ];
}
