<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model{
    use HasFactory;

    
    protected $table = 'productos';

    protected $fillable = [
        'id_categoria',
        'id_subcategoria',
        'id_usuario',
        'nombre',
        'descripcion',
        'precio_dia',
        'precio_semana',
        'precio_mes',
        'disponible',
        'valoracion_media',
    ];


    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function alquileres(){
        return $this->hasMany(Alquiler::class, 'id_producto');
    }

    public function subcategoria(){
        return $this->belongsTo(Subcategoria::class, 'id_subcategoria');
    }
    public function categoria(){
        return $this->belongsTo(categoria::class, 'id_categoria');
    }

    public function imagenes(){
        return $this->hasMany(ImagenProducto::class, 'id_producto');
    }
    public function valoracions(){
        return $this->hasMany(Valoracion::class,'id_usuario');
    }
    public function favoritos(){
        return $this->hasMany(Favorito::class,'id_usuario');
    }
    public function caracteristicas(){
        return $this->hasOne(Caracteristica::class, 'id_producto');

    }
}
