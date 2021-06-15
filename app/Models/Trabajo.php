<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'electricista_id',
        'codigo_trabajo',
        'nombre_trabajo',
        'cliente_id',
        'ubicacion',
        'descripcion',
        'cotizacion_estado',
        'avance_estado',
        'potencia',
        'tipo_trabajo',
    ];

    protected $dates = ['deleted_at'];

    public function electricista()
    {
        return $this->belongsTo(User::class, 'electricista_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function agendamientos()
    {
        return $this->hasMany(Agendamiento::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function materiales()
    {
        return $this->hasMany(TrabajoMaterial::class);
    }
}
