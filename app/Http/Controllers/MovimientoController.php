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
    protected const EXPORT_SCOPE_SALIDAS = 'salidas';
    protected const EXPORT_SCOPE_LOTES = 'lotes';
    protected const EXPORT_SCOPE_GENERAL = 'general';

    public function index(Request $request): View
    {
        $movimientos = $this->filteredQuery($request)
            ->orderByDesc('fecha_salida')
            ->orderByDesc('hora_salida')
            ->paginate(8, ['*'], 'salidas_page')
            ->withQueryString();

        $lotesHistorial = $this->filteredLotesQuery($request)
            ->orderByDesc('fecha_entrada')
            ->orderByDesc('id')
            ->paginate(8, ['*'], 'lotes_page')
            ->withQueryString();

        return view('movimientos.index', [
            'movimientos' => $movimientos,
            'lotesHistorial' => $lotesHistorial,
            'lotes' => Lote::query()->orderBy('numero_lote')->get(),
            'filtrosSalidas' => $request->only(['fecha_desde', 'fecha_hasta', 'lote_id', 'cantidad_min', 'cantidad_max']),
            'filtrosLotes' => $request->only(['numero_lote', 'entrada_desde', 'entrada_hasta']),
            'filtrosGeneral' => $request->only(['general_desde', 'general_hasta']),
            'titulo' => $request->routeIs('admin.*') ? 'Historial general de movimientos' : 'Historial de salidas',
        ]);
    }

    public function exportPdf(Request $request): Response
    {
        $scope = $this->resolveExportScope($request);
        $movimientos = $this->exportMovimientos($request, $scope);
        $lotesHistorial = $this->exportLotes($request, $scope);

        $pdf = Pdf::loadView('movimientos.reporte_pdf', [
            'scope' => $scope,
            'titulo' => $this->exportTitle($scope, $request),
            'movimientos' => $movimientos,
            'lotesHistorial' => $lotesHistorial,
            'generatedAt' => now(),
        ]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$this->exportFilename($scope, 'pdf').'"',
        ]);
    }

    public function exportExcel(Request $request): Response
    {
        $scope = $this->resolveExportScope($request);
        $movimientos = $this->exportMovimientos($request, $scope);
        $lotesHistorial = $this->exportLotes($request, $scope);

        return response()->view('movimientos.reporte_excel', [
            'scope' => $scope,
            'titulo' => $this->exportTitle($scope, $request),
            'movimientos' => $movimientos,
            'lotesHistorial' => $lotesHistorial,
            'generatedAt' => now(),
        ], 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$this->exportFilename($scope, 'xls').'"',
        ]);
    }

    protected function resolveExportScope(Request $request): string
    {
        $scope = strtolower((string) $request->input('scope', self::EXPORT_SCOPE_GENERAL));

        return in_array($scope, [
            self::EXPORT_SCOPE_SALIDAS,
            self::EXPORT_SCOPE_LOTES,
            self::EXPORT_SCOPE_GENERAL,
        ], true) ? $scope : self::EXPORT_SCOPE_GENERAL;
    }

    protected function exportMovimientos(Request $request, string $scope)
    {
        if ($scope === self::EXPORT_SCOPE_LOTES) {
            return collect();
        }

        $query = $this->filteredQuery($request);

        if ($scope === self::EXPORT_SCOPE_GENERAL) {
            $query
                ->when($request->filled('general_desde'), function (Builder $builder) use ($request) {
                    $builder->whereDate('fecha_salida', '>=', $request->string('general_desde'));
                })
                ->when($request->filled('general_hasta'), function (Builder $builder) use ($request) {
                    $builder->whereDate('fecha_salida', '<=', $request->string('general_hasta'));
                });
        }

        return $query->orderByDesc('fecha_salida')
            ->orderByDesc('hora_salida')
            ->get();
    }

    protected function exportLotes(Request $request, string $scope)
    {
        if ($scope === self::EXPORT_SCOPE_SALIDAS) {
            return collect();
        }

        $query = $this->filteredLotesQuery($request);

        if ($scope === self::EXPORT_SCOPE_GENERAL) {
            $query
                ->when($request->filled('general_desde'), function (Builder $builder) use ($request) {
                    $builder->whereDate('fecha_entrada', '>=', $request->string('general_desde'));
                })
                ->when($request->filled('general_hasta'), function (Builder $builder) use ($request) {
                    $builder->whereDate('fecha_entrada', '<=', $request->string('general_hasta'));
                });
        }

        return $query->orderByDesc('fecha_entrada')
            ->orderByDesc('id')
            ->get();
    }

    protected function exportTitle(string $scope, Request $request): string
    {
        $baseTitle = match ($scope) {
            self::EXPORT_SCOPE_SALIDAS => 'Historial de salidas',
            self::EXPORT_SCOPE_LOTES => 'Historial de lotes',
            default => 'Historial general',
        };

        $rangeLabel = match ($scope) {
            self::EXPORT_SCOPE_SALIDAS => $this->dateRangeLabel(
                $request->input('fecha_desde'),
                $request->input('fecha_hasta')
            ),
            self::EXPORT_SCOPE_LOTES => $this->dateRangeLabel(
                $request->input('entrada_desde'),
                $request->input('entrada_hasta')
            ),
            default => $this->dateRangeLabel(
                $request->input('general_desde'),
                $request->input('general_hasta')
            ),
        };

        return trim($baseTitle.' '.$rangeLabel.' - Frigorlato');
    }

    protected function exportFilename(string $scope, string $extension): string
    {
        $prefix = match ($scope) {
            self::EXPORT_SCOPE_SALIDAS => 'historial_salidas',
            self::EXPORT_SCOPE_LOTES => 'historial_lotes',
            default => 'historial_general',
        };

        return $prefix.'_'.now()->format('Ymd_His').'.'.$extension;
    }

    protected function dateRangeLabel(?string $from, ?string $to): string
    {
        if ($from && $to) {
            return 'desde '.$from.' hasta '.$to;
        }

        if ($from) {
            return 'desde '.$from;
        }

        if ($to) {
            return 'hasta '.$to;
        }

        return '';
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

    protected function filteredLotesQuery(Request $request): Builder
    {
        return Lote::query()
            ->with('user')
            ->withCount('movimientos')
            ->when($request->filled('numero_lote'), function (Builder $query) use ($request) {
                $query->where('numero_lote', 'like', '%'.$request->string('numero_lote')->trim().'%');
            })
            ->when($request->filled('entrada_desde'), function (Builder $query) use ($request) {
                $query->whereDate('fecha_entrada', '>=', $request->string('entrada_desde'));
            })
            ->when($request->filled('entrada_hasta'), function (Builder $query) use ($request) {
                $query->whereDate('fecha_entrada', '<=', $request->string('entrada_hasta'));
            });
    }
}
