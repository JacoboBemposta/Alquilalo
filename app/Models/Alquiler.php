<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquiler extends Model{
    use HasFactory;
    protected $table = 'alquilers';

    protected $fillable = [
        'id_producto',
        'id_arrendador',
        'id_arrendatario',
        'fecha_inicio',
        'fecha_fin',
        'precio_total',
        'fianza',
        'transaction_id',
        'is_range',
    ];
    protected $dates = ['fecha_inicio', 'fecha_fin'];

        // Accesor para formatear fecha_inicio
        public function getFechaInicioAttribute($value)
        {
            return \Carbon\Carbon::parse($value)->format('d-m-Y');
        }
    
        // Accesor para formatear fecha_fin
        public function getFechaFinAttribute($value)
        {
            return \Carbon\Carbon::parse($value)->format('d-m-Y');
        }

    public function producto(){
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function arrendatario(){
        return $this->belongsTo(User::class, 'id_arrendatario');
    }

    public function arrendador(){
        return $this->belongsTo(User::class, 'id_arrendador');
    }

    public function incidencia(){
        return $this->hasOne(Incidencia::class);
    }

    public function entregasRecogidas()
    {
        return $this->hasMany(EntregaRecogida::class, 'alquiler_id');
    }    
}
