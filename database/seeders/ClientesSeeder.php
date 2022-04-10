<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clientes')->insert([
        [
            'cliente_id' => 1,
            'nombre' => 'Arcor SA',
            'nombreFantasia' => 'Arcor',
            'direccion' => 'Av. Congreso 2655 CABA',
            'condicion_id' => 1,
            'usuario_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
         [
             'cliente_id' => 2,
             'nombre' => 'Toyota Argentina SA',
             'nombreFantasia' => 'Toyota Zárate',
             'direccion' => 'Av. Tres de Febrero 5632 Zárate',
             'condicion_id' => 1,
             'usuario_id' => 1,
             'created_at' => now(),
             'updated_at' => now(),
         ]
        ]);
    }
}
