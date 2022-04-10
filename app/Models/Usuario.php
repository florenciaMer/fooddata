<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

/**
 * App\Models\Usuario
 *
 * @property int $usuario_id
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Producto[] $productos
 * @property-read int|null $productos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario query()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereUsuarioId($value)
 * @mixin \Eloquent
 * @property string $nombre
 * @property int $rol
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereRol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereToken($value)
 */
class Usuario extends User
{
    // use HasFactory;
    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';

    protected $fillable = [
        'email',
        'password',
        'nombre',
        'password_confirm',
        'rol',
    ];
    //el hidden indica que la columna password no la guarda cuando serializa

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'email'    => 'required|string|email|max:255',
        'password' => 'required',
        'nombre'   => 'required',
        'password_confirm' => 'required|same:password',
    ];

    public static $validarEdicion = [
        'email'    => 'required|string|email|max:255',
        'nombre'   => 'required',
    ];

    public static $validarPassword = [
        'password_confirm' => 'required|same:password',
        'password'          => 'required',
    ];

    public static $validarEmail = [
        'email'    => 'required|string|email|max:255',
    ];

    public static $validarEmailPassword = [
        'email'    => 'required|string|email|max:255',
        'password' => 'required',
    ];

    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'email.required' => 'Debés  ingresar el email para poder ingresar.',
        'email.email' => 'El formato no coincide con una dirección de email.',
        'email.max' => 'Excediste el número máximo de caracteres.',
        'password.required' => 'Debés completar este campo.',
        'nombre.required'   => 'El nombre es requerido',
        'password_confirm.same' => 'Las Contraseñas no coinciden',
        'password_confirm.required' => 'Debés completar este campo.',
        'rol.required' => 'El rol no puede estar en 0',
        'rol.numeric' => 'El rol debe ser un número',
        'rol.min' => 'El rol debe ser 1 o 2',
        'rol.max' => 'El rol debe ser 1 o 2',

    ];
    public function productos(){
        return $this->hasMany(Producto::class, 'usuario_id');
    }
    /* public function esAdmin() {
         return $this->rol === '1';
     }*/
}
