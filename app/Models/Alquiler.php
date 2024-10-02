<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model
{
    use HasFactory;

    public function producto(){
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function arrendatario(){
        return $this->belongsTo(User::class, 'id_usuario_arrendatario');
    }

    public function arrendador(){
        return $this->belongsTo(User::class, 'id_usuario_arrendador');
    }
}
