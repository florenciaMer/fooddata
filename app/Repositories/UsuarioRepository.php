<?php



namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Usuario;

class UsuarioRepository
{
    public function create($data = [])
    {
        return Usuario::create($data);
    }
}
