<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class NegocioMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'electricista_id',
        'material_id',
        'negocio_id',
        'precio',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'electricista_id');
    }

    public function negocio()
    {
        return $this->belongsTo(Negocio::class, 'negocio_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function trabajo_material()
    {
        return $this->hasMany(TrabajoMaterial::class);
    }
}
