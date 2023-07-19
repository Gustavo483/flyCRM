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
        Schema::create('tb_observacoes_leads', function (Blueprint $table) {
            $table->id('id_observacao');
            $table->foreignId('id_lead')->constrained('tb_leads','id_lead');
            $table->integer('bl_oportunidade');
            $table->date('dt_contato');
            $table->string('st_titulo');
            $table->string('st_descricao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_observacoes_leads');
    }
};
