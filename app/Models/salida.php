<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;

    // Esto permite que Laravel guarde los datos que enviamos desde el formulario
    protected $fillable = [
        'lote_id',
        'cantidad_salida_libras',
        'fecha_salida',
        'cliente'
    ];

    // Relación para saber de qué lote salió la carne
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}