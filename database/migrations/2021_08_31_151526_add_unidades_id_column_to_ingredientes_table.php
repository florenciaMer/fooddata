<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class   AddUnidadesIdColumnToIngredientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingredientes', function (Blueprint $table) {
            $table->unsignedSmallInteger('unidad_id')->default(1);
            $table->foreign('unidad_id')->references('unidad_id')->on('unidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingredientes', function (Blueprint $table) {
            $table->dropForeign('unidad_id');
            $table->dropColumn('unidad_id');
        });
    }
}

