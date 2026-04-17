<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_lote')->unique();
            $table->decimal('cantidad_entrada_libras', 10, 2);
            $table->decimal('saldo_actual_libras', 10, 2);
            $table->date('fecha_entrada');
            $table->date('fecha_vencimiento');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};