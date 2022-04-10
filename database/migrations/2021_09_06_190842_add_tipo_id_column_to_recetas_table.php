<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoIdColumnToRecetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recetas', function (Blueprint $table) {
            $table->unsignedSmallInteger('tipo_id')->default(1);
            $table->foreign('tipo_id')->references('tipo_id')->on('tipos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recetas', function (Blueprint $table) {
            $table->dropForeign('tipo_id');
            $table->dropColumn('tipo_id');
        });
    }
}
