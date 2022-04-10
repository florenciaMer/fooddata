<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteserviciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clienteservicios', function (Blueprint $table) {
            $table->smallIncrements('clienteServicio_id');
            $table->integer('cliente_id');
            $table->unsignedDecimal('precio');
            $table->timestamps();
        });
        }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clienteservicios');
    }
}
