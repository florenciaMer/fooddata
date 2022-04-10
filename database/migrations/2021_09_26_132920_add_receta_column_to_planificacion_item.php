<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecetaColumnToPlanificacionItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planificacion_item', function (Blueprint $table) {
            $table->unsignedSmallInteger('receta_id')->default(1);
            $table->foreign('receta_id')->references('receta_id')->on('recetas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planificacion_item', function (Blueprint $table) {
            $table->dropForeign('receta_id');
            $table->dropColumn('receta_id');
        });
    }
}
