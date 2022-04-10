<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class   AddCategoriasIdColumnToIngredientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingredientes', function (Blueprint $table) {
            $table->unsignedSmallInteger('categoria_id')->default(1);
            $table->foreign('categoria_id')->references('categoria_id')->on('categorias');
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
            $table->dropForeign('categoria_id');
            $table->dropColumn('categoria_id');
        });
    }
}
