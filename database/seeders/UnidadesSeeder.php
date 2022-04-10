<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidades')->insert([
            [
                'unidad_id' => 1,
                'nombre' => 'Kilogramos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unidad_id' => 2,
                'nombre' => 'Unidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unidad_id' => 3,
                'nombre' => 'Litros',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
