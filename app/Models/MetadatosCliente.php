<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetadatosCliente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'key',
        'value'
    ];

    protected $dates = ['deleted_at'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
