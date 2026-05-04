<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Services\InventarioService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class InventarioController extends Controller
{
    public function __construct(
        protected InventarioService $inventarioService
    ) {}

    public function index(Request $request): View
    {
        $lotes = $this->filteredQuery($request)
            ->orderBy('fecha_entrada')
            ->paginate(10)
            ->withQueryString();

        return view('inventario.index', [
            'lotes' => $lotes,
            'stockTotal' => $this->inventarioService->stockTotal(),
            'filtros' => $request->only(['numero_lote', 'fecha_desde', 'fecha_hasta']),
        ]);
    }

    public function exportPdf(Request $request): Response
    {
        $inventario = $this->filteredQuery($request)
            ->orderBy('fecha_entrada')
            ->get();

        $pdf = Pdf::loadView('inventario.reporte_pdf', [
            'inventario' => $inventario,
            'generatedAt' => now(),
        ]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="inventario_'.now()->format('Ymd_His').'.pdf"',
        ]);
    }

    public function exportExcel(Request $request): Response
    {
        $inventario = $this->filteredQuery($request)
            ->orderBy('fecha_entrada')
            ->get();

        return response()->view('inventario.reporte_excel', [
            'titulo' => 'Reporte de Inventario - Frigorlato',
            'inventario' => $inventario,
            'generatedAt' => now(),
        ], 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="inventario_'.now()->format('Ymd_His').'.xls"',
        ]);
    }

    protected function filteredQuery(Request $request): Builder
    {
        return Lote::query()
            ->where('saldo_disponible', '>', 0)
            ->when($request->filled('numero_lote'), function (Builder $query) use ($request) {
                $query->where('numero_lote', 'like', '%'.$request->string('numero_lote')->trim().'%');
            })
            ->when($request->filled('fecha_desde'), function (Builder $query) use ($request) {
                $query->whereDate('fecha_entrada', '>=', $request->string('fecha_desde'));
            })
            ->when($request->filled('fecha_hasta'), function (Builder $query) use ($request) {
                $query->whereDate('fecha_entrada', '<=', $request->string('fecha_hasta'));
            });
    }
}
