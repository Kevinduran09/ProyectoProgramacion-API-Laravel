<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    protected $table = 'Habitacion';

    protected $fillable = [
        'disponibilidad',
        'precioNoche',
        'tipo_habitacion_id'
    ];

    public function tipoHabitacion(){
        return $this->belongsToMany(TipoHabitacion::class);
    }
}
