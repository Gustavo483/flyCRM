<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_venda_produto', function (Blueprint $table) {
            $table->foreignId('id_venda')->constrained('tb_vendas','id_venda')->onDelete('cascade');
            $table->foreignId('id_produtoServico')->constrained('tb_produto_servicos','id_produtoServico')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_venda_produto');
    }
};
