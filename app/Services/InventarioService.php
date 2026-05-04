<?php

namespace App\Services;

use App\Models\Lote;
use RuntimeException;

class InventarioService
{
    public function stockTotal(): float
    {
        return (float) Lote::query()->sum('saldo_disponible');
    }

    public function validarSalida(float $cantidad): bool
    {
        if ($cantidad <= 0) {
            throw new RuntimeException('La cantidad solicitada debe ser mayor que cero.');
        }

        if ($cantidad > $this->stockTotal()) {
            throw new RuntimeException('La cantidad solicitada supera el inventario disponible.');
        }

        return true;
    }
}
