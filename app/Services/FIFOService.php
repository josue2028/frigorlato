<?php

namespace App\Services;

use App\Models\Lote;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class FIFOService
{
    public function __construct(
        protected InventarioService $inventarioService
    ) {}

    public function procesarSalida(float $cantidadSolicitada): array
    {
        $this->inventarioService->validarSalida($cantidadSolicitada);

        return DB::transaction(function () use ($cantidadSolicitada) {
            $cantidadRestante = round($cantidadSolicitada, 2);
            $ahora = now();
            $numeroSalida = $this->generarNumeroSalida();
            $movimientosGenerados = [];
            $lotesAfectados = [];

            $lotes = Lote::query()
                ->where('saldo_disponible', '>', 0)
                ->orderBy('fecha_entrada')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            foreach ($lotes as $lote) {
                if ($cantidadRestante <= 0) {
                    break;
                }

                $saldoAnterior = round((float) $lote->saldo_disponible, 2);

                if ($saldoAnterior <= 0) {
                    continue;
                }

                // FIFO estricto: se consume por completo el lote mas antiguo
                // antes de pasar al siguiente.
                $cantidadADescontar = $cantidadRestante <= $saldoAnterior
                    ? $cantidadRestante
                    : $saldoAnterior;
                $saldoPosterior = round($saldoAnterior - $cantidadADescontar, 2);

                if ($saldoPosterior < 0) {
                    throw new RuntimeException('La operacion genera un saldo negativo no permitido.');
                }

                $movimiento = Movimiento::create([
                    'numero_salida' => $numeroSalida,
                    'fecha_salida' => $ahora->toDateString(),
                    'hora_salida' => $ahora->format('H:i:s'),
                    'cantidad_libras' => $cantidadADescontar,
                    'lote_id' => $lote->id,
                    'user_id' => Auth::id(),
                    'saldo_anterior' => $saldoAnterior,
                    'saldo_posterior' => $saldoPosterior,
                    'created_at' => $ahora,
                ]);

                $lote->update([
                    'saldo_disponible' => $saldoPosterior,
                ]);

                $cantidadRestante = round($cantidadRestante - $cantidadADescontar, 2);

                $movimientosGenerados[] = $movimiento;
                $lotesAfectados[] = [
                    'lote_id' => $lote->id,
                    'numero_salida' => $numeroSalida,
                    'numero_lote' => $lote->numero_lote,
                    'cantidad_descontada' => $cantidadADescontar,
                    'saldo_anterior' => $saldoAnterior,
                    'saldo_posterior' => $saldoPosterior,
                ];
            }

            if ($cantidadRestante > 0) {
                throw new RuntimeException('No fue posible completar la salida solicitada por falta de inventario.');
            }

            return [
                'numero_salida' => $numeroSalida,
                'cantidad_solicitada' => round($cantidadSolicitada, 2),
                'movimientos' => $movimientosGenerados,
                'lotes_afectados' => $lotesAfectados,
            ];
        });
    }

    protected function generarNumeroSalida(): string
    {
        $ultimoNumero = Movimiento::query()
            ->whereNotNull('numero_salida')
            ->orderByDesc('id')
            ->value('numero_salida');

        $consecutivo = 1;

        if (is_string($ultimoNumero) && preg_match('/^SAL-(\d+)$/', $ultimoNumero, $matches) === 1) {
            $consecutivo = ((int) $matches[1]) + 1;
        }

        return 'SAL-'.str_pad((string) $consecutivo, 6, '0', STR_PAD_LEFT);
    }
}
