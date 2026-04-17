<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = [
        'numero_lote',
        'cantidad_entrada_libras',
        'saldo_actual_libras',
        'fecha_entrada',
        'fecha_vencimiento'
    ];

    // Esto es para que Laravel entienda las fechas automáticamente
    protected $casts = [
        'fecha_entrada' => 'date',
        'fecha_vencimiento' => 'date',
    ];
}