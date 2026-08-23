<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo', 40); // ej: listado_maestro, indicadores, solicitudes_periodo
            $table->string('nombre', 150);
            $table->json('parametros')->nullable();
            $table->string('archivo_ruta', 500)->nullable();
            $table->unsignedInteger('generado_por');
            $table->timestamp('generado_en')->useCurrent();

            $table->foreign('generado_por')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
