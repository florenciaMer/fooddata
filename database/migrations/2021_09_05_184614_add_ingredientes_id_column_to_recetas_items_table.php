<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIngredientesIdColumnToRecetasItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recetasItems', function (Blueprint $table) {
            $table->unsignedSmallInteger('ingrediente_id')->default(1);
            $table->foreign('ingrediente_id')->references('ingrediente_id')->on('ingredientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recetas_items', function (Blueprint $table) {
            $table->dropForeign('ingrediente_id');
            $table->dropColumn('ingrediente_id');
        });
    }
}
