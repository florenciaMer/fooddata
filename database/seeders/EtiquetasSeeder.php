<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtiquetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('etiquetas')->insert([
            [
                'etiqueta_id' => 1,
                'nombre' => 'Desayuno',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'etiqueta_id' => 2,
                'nombre' => 'Almuerzo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'etiqueta_id' => 3,
                'nombre' => 'Merienda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'etiqueta_id' => 4,
                'nombre' => 'Cena',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'etiqueta_id' => 5,
                'nombre' => 'Refrigerio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'etiqueta_id' => 6,
                'nombre' => 'Colacion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'etiqueta_id' => 7,
                'nombre' => 'Vianda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
