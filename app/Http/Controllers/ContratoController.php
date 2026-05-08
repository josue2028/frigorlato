<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContratoRequest;
use App\Models\Contrato;
use App\Models\Lote;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContratoController extends Controller
{
    public function index(Request $request): View
    {
        return view('contratos.create', [
            'lotes' => Lote::query()->orderBy('numero_lote')->get(),
            'contratos' => $this->filteredContracts($request),
            'filtros' => $request->only(['lote_id']),
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('admin.contratos.index');
    }

    public function store(StoreContratoRequest $request): RedirectResponse
    {
        $archivo = $request->file('archivo');
        $nombreOriginal = $archivo->getClientOriginalName();
        $nombreGuardado = Str::uuid()->toString().'_'.$nombreOriginal;
        $ruta = $archivo->storeAs('contratos', $nombreGuardado);

        Contrato::create([
            'lote_id' => $request->validated('lote_id'),
            'nombre_archivo' => $nombreOriginal,
            'ruta_archivo' => $ruta,
            'user_id' => $request->user()->id,
            'created_at' => now(),
        ]);

        return redirect()
            ->route('admin.contratos.index')
            ->with('success', 'Contrato cargado correctamente.');
    }

    public function download(Contrato $contrato): StreamedResponse
    {
        abort_unless(Storage::disk('local')->exists($contrato->ruta_archivo), 404);

        return Storage::disk('local')->download($contrato->ruta_archivo, $contrato->nombre_archivo);
    }

    public function show(Contrato $contrato): Response|BinaryFileResponse|StreamedResponse
    {
        abort_unless(Storage::disk('local')->exists($contrato->ruta_archivo), 404);

        $absolutePath = Storage::disk('local')->path($contrato->ruta_archivo);
        $mimeType = mime_content_type($absolutePath) ?: 'application/octet-stream';

        return response()->file($absolutePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.$contrato->nombre_archivo.'"',
        ]);
    }

    public function destroy(Contrato $contrato): RedirectResponse
    {
        Storage::disk('local')->delete($contrato->ruta_archivo);
        $contrato->delete();

        return redirect()
            ->route('admin.contratos.index')
            ->with('success', 'Contrato eliminado correctamente.');
    }

    protected function filteredContracts(Request $request): LengthAwarePaginator
    {
        return Contrato::query()
            ->with(['lote', 'user'])
            ->when($request->filled('lote_id'), function ($query) use ($request) {
                $query->where('lote_id', $request->integer('lote_id'));
            })
            ->latest('created_at')
            ->paginate(8)
            ->withQueryString();
    }
}
