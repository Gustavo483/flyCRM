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
        Schema::create('tb_responsavel_lead', function (Blueprint $table) {
            $table->foreignId('id_responsavel')->constrained('users','id')->onDelete('cascade');
            $table->foreignId('id_lead')->constrained('tb_leads','id_lead')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_responsavel_lead');
    }
};
