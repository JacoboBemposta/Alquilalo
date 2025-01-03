<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable{
    use HasFactory, Notifiable;
    public function productos(){
        return $this->hasMany(Producto::class, 'id_usuario');
    }

    public function alquileresComoArrendatario(){
        return $this->hasMany(Alquiler::class, 'id_arrendatario');
    }

    public function alquileresComoArrendador(){
        return $this->hasMany(Alquiler::class, 'id_arrendador');
    }
    public function valoracions(){
        return $this->hasMany(Valoracion::class,'id_usuario');
    }
    public function favoritos(){
        return $this->hasMany(Favorito::class,'id_usuario');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->is_admin;  // Asegúrate de que 'is_admin' esté en la base de datos
    }
}
