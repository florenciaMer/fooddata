<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clienteservicios')->insert([
            [
                'clienteServicio_id' => 1,
                'cliente_id' => 1,
                'usuario_id' =>2,
                'etiqueta_id' => 1, //desayuno
                'precio' => 150,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'clienteServicio_id' => 2,
                'cliente_id' => 1,
                'usuario_id' => 2,
                'etiqueta_id' => 2, //Almuerzo
                'precio' => 450,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'clienteServicio_id' => 3,
                'cliente_id' => 2,
                'usuario_id' => 1,
                'etiqueta_id' => 2, //Almuerzo
                'precio' => 450,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'clienteServicio_id' => 4,
                'cliente_id' => 2,
                'usuario_id' => 1,
                'etiqueta_id' => 3, //Merienda
                'precio' => 150,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
        ]);
    }
}
