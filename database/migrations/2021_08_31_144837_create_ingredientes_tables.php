<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredientes', function (Blueprint $table) {
            $table->smallIncrements('ingrediente_id');
            $table->text('nombre', 100);
            $table->unsignedBigInteger('precio');
            $table->double('impuesto');
        //$table->text('imagen', 150);
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
        Schema::dropIfExists('ingredientes_tables');
    }
}
