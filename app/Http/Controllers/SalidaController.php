<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalidaRequest;
use App\Services\FIFOService;
use App\Services\InventarioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SalidaController extends Controller
{
    public function __construct(
        protected FIFOService $fifoService,
        protected InventarioService $inventarioService
    ) {}

    public function create(): View
    {
        return view('despachador.salidas.create', [
            'stockTotal' => $this->inventarioService->stockTotal(),
        ]);
    }

    public function store(StoreSalidaRequest $request): RedirectResponse
    {
        $resultado = $this->fifoService->procesarSalida((float) $request->validated('cantidad_libras'));

        $detalle = collect($resultado['lotes_afectados'])
            ->map(fn (array $lote) => "{$lote['numero_lote']}: {$lote['cantidad_descontada']} lb")
            ->implode(' | ');

        return redirect()
            ->route('salidas.create')
            ->with('success', "Salida {$resultado['numero_salida']} registrada correctamente. Lotes usados: {$detalle}");
    }
}
