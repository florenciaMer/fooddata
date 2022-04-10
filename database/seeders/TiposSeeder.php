<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('tipos')->insert([
            [
                'tipo_id' => 1,
                'nombre' => 'Entrada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_id' => 2,
                'nombre' => 'Plato Principal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_id' => 3,
                'nombre' => 'Guarnición',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_id' => 4,
                'nombre' => 'Postre',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_id' => 5,
                'nombre' => 'Infusiones',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_id' => 6,
                'nombre' => 'Panadería',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
