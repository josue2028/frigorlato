<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LoteController extends Controller
{
    public function dashboard()
    {
        $totalLotes = Lote::where('saldo_actual_libras', '>', 0)->count();
        $librasDisponibles = Lote::sum('saldo_actual_libras');
        $proximosAVencer = Lote::where('saldo_actual_libras', '>', 0)
            ->where('fecha_vencimiento', '<=', Carbon::now()->addDays(15))
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        return view('dashboard', compact('totalLotes', 'librasDisponibles', 'proximosAVencer'));
    }

    public function index()
    {
        $lotes = Lote::orderBy('fecha_vencimiento', 'asc')->get();
        return view('lotes.index', compact('lotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_lote' => 'required|unique:lotes',
            'cantidad' => 'required|numeric|min:0.01',
            'fecha_entrada' => 'required|date',
        ]);

        // HU-04: Lógica automática de 45 días
        $fechaEntrada = Carbon::parse($request->fecha_entrada);
        $fechaVencimiento = $fechaEntrada->copy()->addDays(45);

        Lote::create([
            'numero_lote' => $request->numero_lote,
            'cantidad_entrada_libras' => $request->cantidad,
            'saldo_actual_libras' => $request->cantidad,
            'fecha_entrada' => $request->fecha_entrada,
            'fecha_vencimiento' => $fechaVencimiento,
        ]);

        return redirect()->route('lotes.index')->with('success', 'Lote registrado con éxito');
    }
}