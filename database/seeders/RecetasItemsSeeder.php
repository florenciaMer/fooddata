<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RecetasItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recetasitems')->insert([
            [
                'recetaItem_id' => 1,
                'usuario_id' =>2,
                'receta_id' => 1, //huevo duro
                'ingrediente_id' => 4, //huevo
                'cant' => 100,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
        ],
            [
                'recetaItem_id' => 2,
                'usuario_id' =>3,
                'receta_id' => 1, //huevo duro
                'ingrediente_id' => 8,  //aceite
                'cant' => 6,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
        ],
            [
                'recetaItem_id' => 3,
                'usuario_id' =>3,
                'receta_id' => 2, //huevo
                'ingrediente_id' => 8,  //aceite
                'cant' => 6,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
        ],
            [
                'recetaItem_id' => 4,
                'usuario_id' =>2,
                'receta_id' => 3, //huevos revueltos
                'ingrediente_id' => 4,  //huevo
                'cant' => 100,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ], [
                'recetaItem_id' => 5,
                'usuario_id' =>3,
                'receta_id' => 3, //huevor revueltos
                'ingrediente_id' => 8,  //aceite
                'cant' => 6,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'recetaItem_id' => 6,
                'usuario_id' =>2,
                'receta_id' => 4, //milanesa
                'ingrediente_id' => 4,  //huevo
                'cant' => 6,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'recetaItem_id' => 7,
                'usuario_id' =>2,
                'receta_id' => 4, //milanesas
                'ingrediente_id' => 8,  //aceite
                'cant' => 6,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'recetaItem_id' => 8,
                'usuario_id' =>2,
                'receta_id' => 4, //milanesas
                'ingrediente_id' => 10,  //nalga sin tapa
                'cant' => 12,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],

            [
                'recetaItem_id' => 9,
                'usuario_id' =>2,
                'receta_id' => 5, //pure de papas
                'ingrediente_id' => 8,  //aceite
                'cant' => 6,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'recetaItem_id' => 10,
                'usuario_id' =>2,
                'receta_id' => 5, //pure de papas
                'ingrediente_id' => 9,  //papa
                'cant' => 6,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'recetaItem_id' => 11,
                'usuario_id' =>2,
                'receta_id' => 6, // cafe con leche
                'ingrediente_id' => 11,  //café molido
                'cant' => 1,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],

            [
                'recetaItem_id' => 12,
                'usuario_id' =>2,
                'receta_id' => 6, // cafe con leche
                'ingrediente_id' => 5,  //leche en polvo
                'cant' => 1,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],

            [
                'recetaItem_id' => 13,
                'usuario_id' =>2,
                'receta_id' => 7, // panal de membrillo
                'ingrediente_id' => 1,  //panal de membrillo
                'cant' => 100,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
       ]);
    }
}
