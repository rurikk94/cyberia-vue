<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'trabajo_id',
        'nombre_original',
        'nombre_archivo',
        'descripcion',
        'peso',
        'extension',
        'documento_historial_id',
    ];

    protected $dates = ['deleted_at'];

    public function trabajo()
    {
        return $this->belongsTo(Trabajo::class, 'trabajo_id');
    }

    public function documento_padre()
    {
        return $this->belongsTo(Documento::class, 'documento_historial_id');
    }

    public function documentos_previo()
    {
        return $this->hasMany(Documento::class);
    }
}
