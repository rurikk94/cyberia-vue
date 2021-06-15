<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TrabajoMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'trabajo_id',
        'material_id',
        'negocio_material_id',
        'cantidad',
        'precio',
    ];

    protected $dates = ['deleted_at'];

    public function trabajo()
    {
        return $this->belongsTo(Trabajo::class, 'trabajo_id');
    }

    public function negocio_material()
    {
        return $this->belongsTo(NegocioMaterial::class, 'negocio_material_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

}
