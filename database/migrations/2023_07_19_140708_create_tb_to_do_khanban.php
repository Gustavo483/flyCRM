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
        Schema::create('tb_to_do_khanban', function (Blueprint $table) {
            $table->id('id_toDoKhanban');
            $table->foreignId('id_columnsKhanban')->constrained('tb_columns_khanban','id_columnsKhanban');
            $table->foreignId('id_user')->constrained('users','id');
            $table->string('st_descricao');
            $table->integer('int_posicao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb__to_do_khanban');
    }
};
