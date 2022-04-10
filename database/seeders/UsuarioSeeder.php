<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('usuarios')->insert([
            [
                'usuario_id' => 1,
                'email' => 'Admin@gmail.com',
                'password' => Hash::make('1234'),
                'nombre'   => 'admin',
                'rol'    => 1,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'usuario_id' => 2,
                'email' => 'maria@gmail.com',
                'password' => Hash::make('1234'),
                'nombre'   => 'Maria',
                'rol'    => 2,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],
            [
                'usuario_id' => 3,
                'email' => 'jose@gmail.com',
                'password' => Hash::make('1234'),
                'nombre'   => 'Jose',
                'rol'    => 2,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ]
        ]);
    }
}
