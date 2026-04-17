<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\InventarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect()->route('dashboard'); });

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LoteController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/lotes', [LoteController::class, 'index'])->name('lotes.index');
    Route::post('/lotes', [LoteController::class, 'store'])->name('lotes.store');
    Route::get('/inventario-pdf', [InventarioController::class, 'downloadPDF'])->name('inventario.pdf');

    Route::get('/salidas', [SalidaController::class, 'index'])->name('salidas.index');
    Route::post('/salidas', [SalidaController::class, 'store'])->name('salidas.store');

    // Rutas de Inventario
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/{id}', [InventarioController::class, 'show'])->name('inventario.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';