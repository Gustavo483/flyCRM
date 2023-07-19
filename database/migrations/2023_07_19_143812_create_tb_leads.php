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
        Schema::create('tb_leads', function (Blueprint $table) {
            $table->id('id_lead');
            $table->string('st_nome');
            $table->integer('int_telefone');
            $table->integer('int_posicao');
            $table->string('st_email');
            $table->foreignId('id_origem')->constrained('tb_origens','id_origem');
            $table->foreignId('id_midia')->constrained('tb_midias','id_midia');
            $table->foreignId('id_campanha')->constrained('tb_campanhas','id_campanha');
            $table->foreignId('id_produtoServico')->constrained('tb_produto_servicos','id_produtoServico');
            $table->foreignId('id_fase')->constrained('tb_fases','id_fase');
            $table->foreignId('id_temperatura')->constrained('tb_temperaturas','id_temperatura');
            $table->foreignId('id_grupo')->constrained('tb_grupos','id_grupo');
            $table->string('st_observacoes');
            $table->foreignId('id_userResponsavel')->constrained('users','id');
            $table->foreignId('id_columnsKhanban')->constrained('tb_columns_khanban','id_columnsKhanban');
            $table->foreignId('id_empresa')->constrained('tb_empresas','id_empresa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_leads');
    }
};
