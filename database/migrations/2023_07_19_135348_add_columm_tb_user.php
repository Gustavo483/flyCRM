<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->foreignId('id_empresa')->constrained('tb_empresas','id_empresa');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('id_empresa');
        });
    }
};
