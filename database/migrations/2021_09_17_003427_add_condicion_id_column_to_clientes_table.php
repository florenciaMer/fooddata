<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCondicionIdColumnToClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->unsignedSmallInteger('condicion_id')->default(1);
            $table->foreign('condicion_id')->references('condicion_id')->on('condiciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()

    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign('condicion_id');
            $table->dropColumn('condicion_id');
        });
    }
}
