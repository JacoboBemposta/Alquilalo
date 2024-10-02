<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoracions';

    protected $fillable = [
        'id_usuario',
        'id_producto',
        'descripcion',
        'puntuacion',
        'ruta_imagen'
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
