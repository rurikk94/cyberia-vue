<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    public function materiales()
    {
        return $this->hasMany(Material::class);
    }

    public function negocios()
    {
        return $this->hasMany(Negocio::class);
    }

    public function metadato()
    {
        return $this->hasMany(MetadatosUsuario::class);
    }

    public function trabajos()
    {
        return $this->hasMany(Trabajo::class);
    }

}
