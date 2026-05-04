<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Movimiento;
use App\Services\InventarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected InventarioService $inventarioService
    ) {}

    public function index(): RedirectResponse
    {
        return redirect()->route('admin.dashboard');
    }

    public function admin(): View
    {
        return view('admin.dashboard', [
            'stockTotal' => $this->inventarioService->stockTotal(),
            'lotesActivos' => Lote::query()->where('saldo_disponible', '>', 0)->count(),
            'proximoVencimiento' => Lote::query()
                ->where('saldo_disponible', '>', 0)
                ->orderBy('fecha_vencimiento')
                ->first(),
            'movimientosRecientes' => Movimiento::query()
                ->with('lote')
                ->latest('created_at')
                ->take(5)
                ->get(),
        ]);
    }

    public function salidas(): View
    {
        return view('despachador.dashboard', [
            'stockTotal' => $this->inventarioService->stockTotal(),
            'lotesDisponibles' => Lote::query()
                ->where('saldo_disponible', '>', 0)
                ->orderBy('fecha_entrada')
                ->orderBy('id')
                ->take(8)
                ->get(),
            'lotesProximosAVencer' => Lote::query()
                ->where('saldo_disponible', '>', 0)
                ->whereDate('fecha_vencimiento', '<=', now()->addDays(7)->toDateString())
                ->orderBy('fecha_vencimiento')
                ->take(5)
                ->get(),
            'movimientosRecientes' => Movimiento::query()
                ->with('lote')
                ->latest('created_at')
                ->take(5)
                ->get(),
        ]);
    }
}
