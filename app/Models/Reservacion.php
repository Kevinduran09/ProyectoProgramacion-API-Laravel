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
        'precioTotal',
        'usuario_id'
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }
    public function habitaciones(){
        return $this->belongsToMany(Habitacion::class,'reservacion_habitacion');
    }
}
