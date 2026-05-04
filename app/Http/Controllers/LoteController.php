<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoteRequest;
use App\Http\Requests\UpdateLoteRequest;
use App\Models\Lote;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoteController extends Controller
{
    public function index(): View
    {
        return view('admin.lotes.index', [
            'lotes' => Lote::query()
                ->withCount('movimientos')
                ->latest()
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.lotes.create', [
            'fechaEntradaSugerida' => now()->toDateString(),
            'fechaVencimientoSugerida' => now()->addDays(45)->toDateString(),
        ]);
    }

    public function store(StoreLoteRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $fechaVencimiento = Carbon::parse($data['fecha_entrada'])->addDays(45)->toDateString();

        Lote::create([
            'numero_lote' => $data['numero_lote'],
            'cantidad_entrada' => $data['cantidad_entrada'],
            'fecha_entrada' => $data['fecha_entrada'],
            'fecha_vencimiento' => $fechaVencimiento,
            'saldo_disponible' => $data['cantidad_entrada'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('admin.lotes.index')
            ->with('success', 'Lote creado correctamente. Fecha de vencimiento calculada a 45 dias.');
    }

    public function edit(Lote $lote): View|RedirectResponse
    {
        if ($lote->movimientos()->exists()) {
            return redirect()
                ->route('admin.lotes.index')
                ->with('error', 'No puedes editar un lote que ya tiene movimientos asociados.');
        }

        return view('admin.lotes.edit', [
            'lote' => $lote,
            'fechaVencimientoCalculada' => Carbon::parse($lote->fecha_entrada)->addDays(45)->toDateString(),
        ]);
    }

    public function update(UpdateLoteRequest $request, Lote $lote): RedirectResponse
    {
        if ($lote->movimientos()->exists()) {
            return redirect()
                ->route('admin.lotes.index')
                ->with('error', 'No puedes actualizar un lote que ya tiene movimientos asociados.');
        }

        $data = $request->validated();
        $fechaVencimiento = Carbon::parse($data['fecha_entrada'])->addDays(45)->toDateString();

        $lote->update([
            'numero_lote' => $data['numero_lote'],
            'cantidad_entrada' => $data['cantidad_entrada'],
            'fecha_entrada' => $data['fecha_entrada'],
            'fecha_vencimiento' => $fechaVencimiento,
            'saldo_disponible' => $data['cantidad_entrada'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('admin.lotes.index')
            ->with('success', 'Lote actualizado correctamente.');
    }

    public function destroy(Lote $lote): RedirectResponse
    {
        if ($lote->movimientos()->exists()) {
            return redirect()
                ->route('admin.lotes.index')
                ->with('error', 'No puedes eliminar un lote que ya tiene movimientos asociados.');
        }

        $lote->delete();

        return redirect()
            ->route('admin.lotes.index')
            ->with('success', 'Lote eliminado correctamente.');
    }
}
