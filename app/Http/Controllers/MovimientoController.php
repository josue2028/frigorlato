<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Movimiento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MovimientoController extends Controller
{
    public function index(Request $request): View
    {
        $movimientos = $this->filteredQuery($request)
            ->orderByDesc('fecha_salida')
            ->orderByDesc('hora_salida')
            ->paginate(12)
            ->withQueryString();

        return view('movimientos.index', [
            'movimientos' => $movimientos,
            'lotes' => Lote::query()->orderBy('numero_lote')->get(),
            'filtros' => $request->only(['fecha_desde', 'fecha_hasta', 'lote_id', 'cantidad_min', 'cantidad_max']),
            'titulo' => $request->routeIs('admin.*') ? 'Historial general de movimientos' : 'Historial de salidas',
        ]);
    }

    public function exportPdf(Request $request): Response
    {
        $movimientos = $this->filteredQuery($request)
            ->orderByDesc('fecha_salida')
            ->orderByDesc('hora_salida')
            ->get();

        $pdf = Pdf::loadView('movimientos.reporte_pdf', [
            'movimientos' => $movimientos,
            'generatedAt' => now(),
        ]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="movimientos_'.now()->format('Ymd_His').'.pdf"',
        ]);
    }

    public function exportExcel(Request $request): Response
    {
        $movimientos = $this->filteredQuery($request)
            ->orderByDesc('fecha_salida')
            ->orderByDesc('hora_salida')
            ->get();

        return response()->view('movimientos.reporte_excel', [
            'titulo' => 'Reporte de Movimientos - Frigorlato',
            'movimientos' => $movimientos,
            'generatedAt' => now(),
        ], 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="movimientos_'.now()->format('Ymd_His').'.xls"',
        ]);
    }

    protected function filteredQuery(Request $request): Builder
    {
        return Movimiento::query()
            ->with(['lote', 'user'])
            ->when($request->filled('fecha_desde'), function (Builder $query) use ($request) {
                $query->whereDate('fecha_salida', '>=', $request->string('fecha_desde'));
            })
            ->when($request->filled('fecha_hasta'), function (Builder $query) use ($request) {
                $query->whereDate('fecha_salida', '<=', $request->string('fecha_hasta'));
            })
            ->when($request->filled('lote_id'), function (Builder $query) use ($request) {
                $query->where('lote_id', $request->integer('lote_id'));
            })
            ->when($request->filled('cantidad_min'), function (Builder $query) use ($request) {
                $query->where('cantidad_libras', '>=', (float) $request->input('cantidad_min'));
            })
            ->when($request->filled('cantidad_max'), function (Builder $query) use ($request) {
                $query->where('cantidad_libras', '<=', (float) $request->input('cantidad_max'));
            });
    }
}
