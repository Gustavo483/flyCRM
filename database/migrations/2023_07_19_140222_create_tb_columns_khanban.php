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
        Schema::create('tb_columns_khanban', function (Blueprint $table) {
            $table->id('id_columnsKhanban');
            $table->foreignId('id_empresa')->constrained('tb_empresas','id_empresa');
            $table->string('st_titulo');
            $table->string('st_color');
            $table->integer('int_posicao');
            $table->integer('int_tipoKhanban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_columns_khanban');
    }
};
