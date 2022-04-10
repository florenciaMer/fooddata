<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('planificacion')->insert([
            [
                'planificacion_id' => 1,
                'cliente_id' => 1,
                'usuario_id' => 1,
                'contexto' => 'Escenario',
                'cant' => 100,
                'fecha' => date('2021-10-01'),
                'observaciones' => 'Corresponde a un servicio habitual',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'planificacion_id' => 2,
                'cliente_id' => 1,
                'usuario_id' => 1,
                'contexto' => 'Escenario',
                'cant' => 50,
                'fecha' => date('2021-10-02'),
                'observaciones' => 'Corresponde a un Escenario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'planificacion_id' => 3,
                'cliente_id' => 1,
                'usuario_id' => 1,
                'contexto' => 'Escenario',
                'cant' => 25,
                'fecha' => date('2021-10-03'),
                'observaciones' => 'Corresponde a un Escenario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'planificacion_id' => 4,
                'cliente_id' => 1,
                'usuario_id' => 2,
                'contexto' => 'Escenario',
                'cant' => 20,
                'fecha' => date('2021-10-04'),
                'observaciones' => 'Corresponde a un Escenario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'planificacion_id' => 5,
                'cliente_id' => 1,
                'usuario_id' => 2,
                'contexto' => 'Escenario',
                'cant' => 12,
                'fecha' => date('2021-11-04'),
                'observaciones' => 'Corresponde a un Escenario',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
