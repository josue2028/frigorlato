<?php

namespace Database\Seeders;

use App\Models\Lote;
use App\Models\Movimiento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LotesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $datosLotes = [
            ['numero_lote' => 'FRG-2401', 'cantidad_entrada' => 1500, 'fecha_entrada' => '2026-03-01', 'saldo_disponible' => 1100],
            ['numero_lote' => 'FRG-2402', 'cantidad_entrada' => 1200, 'fecha_entrada' => '2026-03-08', 'saldo_disponible' => 900],
            ['numero_lote' => 'FRG-2403', 'cantidad_entrada' => 980, 'fecha_entrada' => '2026-03-14', 'saldo_disponible' => 980],
            ['numero_lote' => 'FRG-2404', 'cantidad_entrada' => 1325, 'fecha_entrada' => '2026-03-21', 'saldo_disponible' => 1000],
            ['numero_lote' => 'FRG-2405', 'cantidad_entrada' => 860, 'fecha_entrada' => '2026-03-28', 'saldo_disponible' => 640],
        ];

        foreach ($datosLotes as $datos) {
            $lote = Lote::updateOrCreate(
                ['numero_lote' => $datos['numero_lote']],
                [
                    'cantidad_entrada' => $datos['cantidad_entrada'],
                    'fecha_entrada' => $datos['fecha_entrada'],
                    'fecha_vencimiento' => Carbon::parse($datos['fecha_entrada'])->addDays(45)->toDateString(),
                    'saldo_disponible' => $datos['saldo_disponible'],
                    'user_id' => $admin?->id,
                ]
            );

            $cantidadConsumida = round($datos['cantidad_entrada'] - $datos['saldo_disponible'], 2);

            if ($cantidadConsumida > 0) {
                Movimiento::updateOrCreate(
                    [
                        'lote_id' => $lote->id,
                        'fecha_salida' => Carbon::parse($datos['fecha_entrada'])->addDays(5)->toDateString(),
                        'hora_salida' => '08:00:00',
                    ],
                    [
                        'numero_salida' => 'SAL-'.str_pad((string) $lote->id, 6, '0', STR_PAD_LEFT),
                        'cantidad_libras' => $cantidadConsumida,
                        'user_id' => $admin?->id,
                        'saldo_anterior' => $datos['cantidad_entrada'],
                        'saldo_posterior' => $datos['saldo_disponible'],
                        'created_at' => Carbon::parse($datos['fecha_entrada'])->addDays(5)->setTime(8, 0),
                    ]
                );
            }
        }
    }
}
