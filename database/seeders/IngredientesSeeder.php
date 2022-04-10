<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientesSeeder extends Seeder
{
    public function run()
    {
        DB::table('ingredientes')->insert([
            [
                'usuario_id' => 1,
                'ingrediente_id' => 1,
                'categoria_id' => 1, //panaderia
                'nombre' => 'Panal de Membrillo',
                'unidad_id' => 2, //unidad
                'precio' => 2500,
                'impuesto' => 21,
              //  'imagen' => 'img/3f7cf864a67bf42619e270c7c5c975a5.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'usuario_id' =>1,
                'ingrediente_id' => 2,
                'categoria_id' => 1, //panaderia
                'nombre' => 'Pan Flauta',
                'unidad_id' => 1, //kilo
                'precio' => 3000,
                'impuesto' => 21,
               // 'imagen' => 'img/0b17cf30654690e091485e0a483f6006.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],

            [
                'usuario_id' =>1,
                'ingrediente_id' => 3,
                'categoria_id' => 1,  //panaderia
                'nombre' => 'Pan Saborizado',
                'unidad_id' => 2, //kilo
                'impuesto' => 21,
                'precio' => 23000,
             //   'imagen' => 'img/618db1385ebd0163be2299dc59ea1dff.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],

            [
                'usuario_id' =>2,
                'ingrediente_id' => 4,
                'categoria_id' => 2,  //almacen
                'nombre' => 'Huevo',
                'unidad_id' => 2, //unidad
                'precio' => 1500,
                'impuesto' => 21,
             //   'imagen' => 'img/618db1385ebd0163be2299dc59ea1dff.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'usuario_id' =>2,
                'ingrediente_id' => 5,
                'categoria_id' => 2,  //almacen
                'nombre' => 'Leche en polvo',
                'unidad_id' => 1, //kilo
                'precio' => 6000,
                'impuesto' => 21,
               // 'imagen' => 'img/618db1385ebd0163be2299dc59ea1dff.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'usuario_id' =>2,
                'ingrediente_id' => 6,
                'categoria_id' => 2,  //almacen
                'nombre' => 'Azucar a granel',
                'unidad_id' => 1, //kilo
                'precio' => 9000,
                'impuesto' => 21,
               // 'imagen' => 'img/618db1385ebd0163be2299dc59ea1dff.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],

            [
                'usuario_id' =>2,
                'ingrediente_id' => 7,
                'categoria_id' => 2,  //almacen
                'nombre' => 'Harina',
                'unidad_id' => 1, //kilo
                'precio' => 9000,
                'impuesto' => 21,
                // 'imagen' => 'img/618db1385ebd0163be2299dc59ea1dff.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'usuario_id' =>2,
                'ingrediente_id' => 8,
                'categoria_id' => 2,  //almacen
                'nombre' => 'Aceite',
                'unidad_id' => 3, //Litro
                'precio' => 10500,
                'impuesto' => 21,
                // 'imagen' => 'img/618db1385ebd0163be2299dc59ea1dff.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'usuario_id' =>2,
                'ingrediente_id' => 9,
                'categoria_id' => 5,  //verduleria
                'nombre' => 'Papa',
                'unidad_id' => 1, //kilo
                'precio' => 6000,
                'impuesto' => 10.5,
                // 'imagen' => 'img/618db1385ebd0163be2299dc59ea1dff.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],

            [
                'usuario_id' =>2,
                'ingrediente_id' => 10,
                'categoria_id' => 3,  //carne
                'nombre' => 'Nalga sin tapa',
                'unidad_id' => 1, //kilo
                'precio' => 95000,
                'impuesto' => 10.5,
                // 'imagen' => 'img/618db1385ebd0163be2299dc59ea1dff.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],

            [
                'usuario_id' =>2,
                'ingrediente_id' => 11,
                'categoria_id' => 9,  //infusiones
                'nombre' => 'Café molido',
                'unidad_id' => 1, //kilo
                'precio' => 85000,
                'impuesto' => 21,
                // 'imagen' => 'img/618db1385ebd0163be2299dc59ea1dff.jpg',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
        ]);
    }
}
