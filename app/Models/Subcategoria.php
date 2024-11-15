<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model{
    use HasFactory;

    protected $fillable = ['nombre', 'id_categoria'];
    protected $table='subcategorias';
    
    public function categoria(){
        return $this->belongsTo(Categoria::class,'id_categoria');
    }
    public function productos(){
        return $this->hasMany(Producto::class,'id_subcategoria');
    }
    
}
