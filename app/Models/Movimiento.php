<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    public $timestamps = false;

    protected $fillable = [
        'numero_salida',
        'fecha_salida',
        'hora_salida',
        'cantidad_libras',
        'lote_id',
        'user_id',
        'saldo_anterior',
        'saldo_posterior',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'fecha_salida' => 'date',
            'cantidad_libras' => 'decimal:2',
            'saldo_anterior' => 'decimal:2',
            'saldo_posterior' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function lote(): BelongsTo
    {
        return $this->belongsTo(Lote::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
