<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CondicionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('condiciones')->insert([
            [
                'condicion_id' => 1,
                'nombre' => 'Exento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'condicion_id' => 2,
                'nombre' => 'Gravado',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
