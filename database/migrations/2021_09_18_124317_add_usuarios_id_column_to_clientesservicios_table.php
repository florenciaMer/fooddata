<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsuariosIdColumnToClientesserviciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clienteservicios', function (Blueprint $table) {
            $table->unsignedSmallInteger('usuario_id')->default(1);
            $table->foreign('usuario_id')->references('usuario_id')->on('usuarios');
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
            $table->dropForeign('usuario_id');
            $table->dropColumn('usuario_id');
        });
    }
}
