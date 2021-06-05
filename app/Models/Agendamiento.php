<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Agendamiento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'trabajo_id',
        'fecha_hora_inicio',
        'fecha_hora_fin',
    ];

    protected $dates = ['deleted_at'];

    public function trabajo()
    {
        return $this->belongsTo(Trabajo::class, 'trabajo_id');
    }
}
