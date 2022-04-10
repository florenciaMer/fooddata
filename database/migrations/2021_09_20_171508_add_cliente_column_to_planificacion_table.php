<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClienteColumnToPlanificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planificacion', function (Blueprint $table) {
            $table->unsignedSmallInteger('cliente_id')->default(1);
            $table->foreign('cliente_id')->references('cliente_id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planificacion', function (Blueprint $table) {
            $table->dropForeign('cliente_id');
            $table->dropColumn('cliente_id');
        });
    }
}
