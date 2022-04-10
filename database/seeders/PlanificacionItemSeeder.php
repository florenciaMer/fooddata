<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanificacionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('planificacion_item')->insert([
            [
                'planificacionItem_id' => 1,
                'planificacion_id' => 1,
                'usuario_id' => 1,
                'etiqueta_id' => 1,
                'receta_id' => 6, //Café con leche
                'cant_rec' => 100,
                'tipo_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'planificacionItem_id' => 3,
                'planificacion_id' => 2,
                'usuario_id' => 2,
                'etiqueta_id' => 1,
                'receta_id' => 3,
                'cant_rec' => 25,
                'tipo_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'planificacionItem_id' => 4,
                'planificacion_id' => 3,
                'usuario_id' => 2,
                'etiqueta_id' => 1,
                'receta_id' => 1,  //huevo duro
                'cant_rec' => 20,
                'tipo_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'planificacionItem_id' => 5,
                'planificacion_id' => 4,
                'usuario_id' => 1,
                'etiqueta_id' => 1,
                'receta_id' => 2,
                'cant_rec' => 15,
                'tipo_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'planificacionItem_id' => 6,
                'planificacion_id' => 5,
                'usuario_id' => 2,
                'etiqueta_id' => 2,
                'receta_id' => 2,
                'cant_rec' => 12,
                'tipo_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
