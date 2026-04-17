<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InventarioController extends Controller
{
    public function index()
    {
        $inventario = Lote::orderBy('fecha_vencimiento', 'asc')->get();
        return view('inventario.index', compact('inventario'));
    }

    public function downloadPDF()
    {
        $inventario = Lote::where('saldo_actual_libras', '>', 0)->get();
        
        // Esta línea genera el PDF usando una vista que crearemos ahora
        $pdf = Pdf::loadView('inventario.reporte_pdf', compact('inventario'));
        
        return $pdf->download('reporte-inventario-frigorlato.pdf');
    }
}