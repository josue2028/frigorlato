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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_salida');
            $table->time('hora_salida');
            $table->decimal('cantidad_libras', 10, 2);
            $table->foreignId('lote_id')->constrained('lotes')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('saldo_anterior', 10, 2);
            $table->decimal('saldo_posterior', 10, 2);
            $table->timestamp('created_at')->useCurrent();
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('
                CREATE TRIGGER movimientos_valores_validos_insert
                BEFORE INSERT ON movimientos
                FOR EACH ROW
                WHEN NEW.cantidad_libras <= 0 OR NEW.saldo_anterior < 0 OR NEW.saldo_posterior < 0
                BEGIN
                    SELECT RAISE(ABORT, "Los valores del movimiento no son validos");
                END
            ');
        }

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE movimientos ADD CONSTRAINT chk_movimientos_cantidad CHECK (cantidad_libras > 0)');
            DB::statement('ALTER TABLE movimientos ADD CONSTRAINT chk_movimientos_saldo_anterior CHECK (saldo_anterior >= 0)');
            DB::statement('ALTER TABLE movimientos ADD CONSTRAINT chk_movimientos_saldo_posterior CHECK (saldo_posterior >= 0)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
