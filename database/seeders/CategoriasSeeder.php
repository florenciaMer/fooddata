<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            [
                'categoria_id' => 1,
                'nombre' => 'Panaderia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 2,
                'nombre' => 'Almacen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 3,
                'nombre' => 'Carnes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 4,
                'nombre' => 'Pescados',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 5,
                'nombre' => 'Verduras',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 6,
                'nombre' => 'Frutas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 7,
                'nombre' => 'Aves',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 8,
                'nombre' => 'Pescados',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'categoria_id' => 9,
                'nombre' => 'Infusiones',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
