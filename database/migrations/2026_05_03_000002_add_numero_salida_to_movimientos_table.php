<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->string('numero_salida', 20)->nullable()->after('id');
            $table->index('numero_salida');
        });

        $movimientos = DB::table('movimientos')
            ->orderBy('id')
            ->get(['id']);

        $consecutivo = 1;

        foreach ($movimientos as $movimiento) {
            DB::table('movimientos')
                ->where('id', $movimiento->id)
                ->update([
                    'numero_salida' => 'SAL-'.str_pad((string) $consecutivo, 6, '0', STR_PAD_LEFT),
                ]);

            $consecutivo++;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->dropIndex(['numero_salida']);
            $table->dropColumn('numero_salida');
        });
    }
};
