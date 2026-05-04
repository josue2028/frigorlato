<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lote extends Model
{
    protected $table = 'lotes';

    protected $fillable = [
        'numero_lote',
        'cantidad_entrada',
        'fecha_entrada',
        'fecha_vencimiento',
        'saldo_disponible',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'cantidad_entrada' => 'decimal:2',
            'saldo_disponible' => 'decimal:2',
            'fecha_entrada' => 'date',
            'fecha_vencimiento' => 'date',
        ];
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class);
    }

    public function contratos(): HasMany
    {
        return $this->hasMany(Contrato::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
