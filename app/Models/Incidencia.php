<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    // La tabla que representa el modelo
    protected $table = 'incidencias';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'alquiler_id',
        'descripcion',
        'ruta_imagen',
        'aprobado',  // Agregar el campo aprobado a los campos asignables
    ];

    // Relación con el modelo Alquiler
    public function alquiler()
    {
        return $this->belongsTo(Alquiler::class);
    }
}
