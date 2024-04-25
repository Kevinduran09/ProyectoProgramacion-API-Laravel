<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'Usuario';
    protected $hidden = ['created_at', 'updated_at'];
    // campos que se pueden manipular
    protected $fillable = [
        'cedula',
        'nombre',
        'apellidos',
        'correo',
        'nomUsuario',
        'contraseña'
    ];


    public function reservacion()
    {
        return $this->belongsTo(Reservacion::class);
    }
}
