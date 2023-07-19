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
        Schema::create('tb_temperaturas', function (Blueprint $table) {
            $table->id('id_temperatura');
            $table->foreignId('id_empresa')->constrained('tb_empresas','id_empresa');
            $table->string('st_nomeTemperatura');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_temperaturas');
    }
};
