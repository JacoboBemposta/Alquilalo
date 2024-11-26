<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaRecogida extends Model
{
    use HasFactory;

    protected $table = 'entregas_recogidas';

    protected $fillable = [
        'alquiler_id',
        'estado',
        'fecha_evento',
        'notas',
        'fotos',
    ];

    protected $casts = [
        'fotos' => 'array', // Manejo del JSON para imágenes
        'fecha_evento' => 'datetime', // Fecha como objeto Carbon
    ];

    public function alquiler()
    {
        return $this->belongsTo(Alquiler::class, 'alquiler_id');
    }
}
