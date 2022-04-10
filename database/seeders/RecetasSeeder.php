<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recetas')->insert([
        [
            'receta_id' => 1,
            'usuario_id' => 2,
            'tipo_id' => 1,
            'nombre' => 'Huevo Duro',
            'descripcion' => 'Receta: 1- Poner huevo y batir a punto nieve',
            'base' => 100,
            'imagen' => 'prox.jpg',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ],
         [
             'receta_id' => 2,
             'usuario_id' => 2,
             'tipo_id' => 4,
             'nombre' => 'Bizcochuelo base',
             'descripcion' => 'Paso 1- Batir los huevos',
             'base' => 100,
             'imagen' => 'prox.jpg',
             'created_at' => date('Y-m-d'),
             'updated_at' => date('Y-m-d'),
         ],
         [
             'receta_id' => 3,
             'usuario_id' => 3,
             'tipo_id' => 1,
             'nombre' => 'Huevos Revueltos',
             'descripcion' => 'Paso 1- Los huevo se deben batir ',
             'base' => 100,
             'imagen' => 'prox.jpg',
             'created_at' => date('Y-m-d'),
             'updated_at' => date('Y-m-d'),
         ],

            [
                'receta_id' => 4,
                'usuario_id' => 2,
                'tipo_id' => 2,
                'nombre' => 'Milanesa al horno',
                'descripcion' => 'Batir los huevos y luego empanar la carne',
                'base' => 100,
                'imagen' => 'prox.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],

            [
                'receta_id' => 5,
                'usuario_id' => 2,
                'tipo_id' => 3,
                'nombre' => 'Puré de Papas',
                'descripcion' => 'Pisar las papas hasta que no queden grumos',
                'base' => 100,
                'imagen' => 'prox.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'receta_id' => 6,
                'usuario_id' => 2,
                'tipo_id' => 5, //infusiones
                'nombre' => 'Café con leche',
                'descripcion' => 'Hervir 1 litro de agua y agregar 10 gr de café ',
                'base' => 100,
                'imagen' => 'prox.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'receta_id' => 7,
                'usuario_id' => 2,
                'tipo_id' => 6, //panaderia
                'nombre' => 'Panal de Membrillo',
                'descripcion' => '',
                'base' => 100,
                'imagen' => 'prox.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
        ]);
    }
}
