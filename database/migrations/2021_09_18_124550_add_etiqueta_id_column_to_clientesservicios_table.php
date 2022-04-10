<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEtiquetaIdColumnToClientesserviciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clienteservicios', function (Blueprint $table) {
            $table->unsignedSmallInteger('etiqueta_id')->default(1);
            $table->foreign('etiqueta_id')->references('etiqueta_id')->on('etiquetas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientesservicios', function (Blueprint $table) {
            $table->dropForeign('etiqueta_id');
            $table->dropColumn('etiqueta_id');
        });
    }
}
