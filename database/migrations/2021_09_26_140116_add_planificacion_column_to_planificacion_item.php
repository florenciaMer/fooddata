<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanificacionColumnToPlanificacionItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planificacion_item', function (Blueprint $table) {
            $table->unsignedSmallInteger('planificacion_id')->default(1);
            $table->foreign('planificacion_id')->references('planificacion_id')->on('planificacion');

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
            $table->unsignedSmallInteger('planificacion_id')->default(1);
            $table->foreign('planificacion_id')->references('planificacion_id')->on('planificacion');
        });
    }
}
