<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Salida;
use Illuminate\Http\Request;

class SalidaController extends Controller
{
    public function index()
    {
        $lotesDisponibles = Lote::where('saldo_actual_libras', '>', 0)->get();
        $salidas = Salida::with('lote')->orderBy('created_at', 'desc')->get();
        return view('salidas.index', compact('lotesDisponibles', 'salidas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'cantidad' => 'required|numeric|min:0.01',
            'fecha_salida' => 'required|date',
        ]);

        $lote = Lote::findOrFail($request->lote_id);

        if ($request->cantidad > $lote->saldo_actual_libras) {
            return back()->withErrors(['cantidad' => 'No hay suficiente saldo en este lote.']);
        }

        Salida::create([
            'lote_id' => $lote->id,
            'cantidad_salida_libras' => $request->cantidad,
            'fecha_salida' => $request->fecha_salida,
            'cliente' => $request->cliente ?? 'Consumo Interno',
        ]);

        $lote->decrement('saldo_actual_libras', $request->cantidad);

        return redirect()->route('salidas.index')->with('success', 'Salida registrada correctamente.');
    }
}