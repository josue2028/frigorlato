<?php

use App\Http\Controllers\ContratoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalidaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/salidas', [DashboardController::class, 'salidas'])->name('salidas.dashboard');
    Route::get('/salidas/create', [SalidaController::class, 'create'])->name('salidas.create');
    Route::post('/salidas', [SalidaController::class, 'store'])->name('salidas.store');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/lotes', [LoteController::class, 'index'])->name('lotes.index');
        Route::get('/lotes/create', [LoteController::class, 'create'])->name('lotes.create');
        Route::post('/lotes', [LoteController::class, 'store'])->name('lotes.store');
        Route::get('/lotes/{lote}/edit', [LoteController::class, 'edit'])->name('lotes.edit');
        Route::put('/lotes/{lote}', [LoteController::class, 'update'])->name('lotes.update');
        Route::delete('/lotes/{lote}', [LoteController::class, 'destroy'])->name('lotes.destroy');

        Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
        Route::get('/inventario/export/pdf', [InventarioController::class, 'exportPdf'])->name('inventario.export.pdf');
        Route::get('/inventario/export/excel', [InventarioController::class, 'exportExcel'])->name('inventario.export.excel');
        Route::get('/historial', [MovimientoController::class, 'index'])->name('historial.index');
        Route::get('/historial/export/pdf', [MovimientoController::class, 'exportPdf'])->name('historial.export.pdf');
        Route::get('/historial/export/excel', [MovimientoController::class, 'exportExcel'])->name('historial.export.excel');
        Route::get('/contratos', [ContratoController::class, 'index'])->name('contratos.index');
        Route::get('/contratos/create', [ContratoController::class, 'create'])->name('contratos.create');
        Route::post('/contratos', [ContratoController::class, 'store'])->name('contratos.store');
        Route::get('/contratos/{contrato}/download', [ContratoController::class, 'download'])->name('contratos.download');
        Route::delete('/contratos/{contrato}', [ContratoController::class, 'destroy'])->name('contratos.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
