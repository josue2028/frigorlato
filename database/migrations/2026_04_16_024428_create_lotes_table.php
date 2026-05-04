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
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_lote')->unique();
            $table->decimal('cantidad_entrada', 10, 2);
            $table->date('fecha_entrada');
            $table->date('fecha_vencimiento');
            $table->decimal('saldo_disponible', 10, 2);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('
                CREATE TRIGGER lotes_saldo_no_negativo_insert
                BEFORE INSERT ON lotes
                FOR EACH ROW
                WHEN NEW.saldo_disponible < 0
                BEGIN
                    SELECT RAISE(ABORT, "saldo_disponible no puede ser negativo");
                END
            ');

            DB::statement('
                CREATE TRIGGER lotes_saldo_no_negativo_update
                BEFORE UPDATE ON lotes
                FOR EACH ROW
                WHEN NEW.saldo_disponible < 0
                BEGIN
                    SELECT RAISE(ABORT, "saldo_disponible no puede ser negativo");
                END
            ');
        }

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE lotes ADD CONSTRAINT chk_lotes_saldo_disponible CHECK (saldo_disponible >= 0)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};
