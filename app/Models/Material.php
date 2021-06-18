<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'electricista_id',
        'nombre',
        'marca',
        'modelo',
        'imagen',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'electricista_id');
    }

    public function negocio()
    {
        return $this->hasMany(NegocioMaterial::class);
    }

    public function trabajo()
    {
        return $this->hasMany(TrabajoMaterial::class);
    }
}
