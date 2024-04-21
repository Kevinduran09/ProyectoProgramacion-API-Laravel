<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
    use HasFactory;

    protected $table = 'Reservacion';

    protected $fillable = [
        'fechaIngreso',
        'fechaSalida',
        'estado',
        'precioTotal'
    ];

    public function usuario(){
        return $this->hasOne(Usuario::class);
    }
    public function habitaciones(){
        return $this->hasMany(Habitacion::class);
        
    }
}
