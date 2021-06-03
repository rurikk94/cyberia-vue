<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'electricista_id',
        'nombres',
        'apellidos',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'electricista_id');
    }
}
