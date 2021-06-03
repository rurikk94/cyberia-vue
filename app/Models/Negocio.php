<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Negocio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'electricista_id',
        'nombre',
        'ubicacion',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'electricista_id');
    }

    public function material()
    {
        return $this->hasMany(NegocioMaterial::class);
    }
}
