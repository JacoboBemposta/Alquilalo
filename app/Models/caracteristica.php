<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caracteristica extends Model{
    use HasFactory;

    protected $table = 'caracteristicas';

    protected $fillable = [
        'id_producto',
        'novedad',
        'descripcion',
        'descuento',
    ];

    public function producto(){
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
