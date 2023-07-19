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
        Schema::create('tb_produto_servicos', function (Blueprint $table) {
            $table->id('id_produtoServico');
            $table->foreignId('id_empresa')->constrained('tb_empresas','id_empresa');
            $table->string('st_nomeProdutoServico');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_produto_servicos');
    }
};
