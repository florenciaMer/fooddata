<?php

namespace Database\Seeders;

use App\Models\ClienteServicios;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsuarioSeeder::class);
        $this->call(UnidadesSeeder::class);
        $this->call(TiposSeeder::class);
        $this->call(CategoriasSeeder::class);
        $this->call(IngredientesSeeder::class);
        $this->call(RecetasSeeder::class);
        $this->call(RecetasItemsSeeder::class);
        $this->call(EtiquetasSeeder::class);
        $this->call(CondicionesSeeder::class);
        $this->call(ClientesSeeder::class);
        $this->call(ClienteServiciosSeeder::class);
        $this->call(PlanificacionSeeder::class);
        $this->call(PlanificacionItemSeeder::class);

    }
}
