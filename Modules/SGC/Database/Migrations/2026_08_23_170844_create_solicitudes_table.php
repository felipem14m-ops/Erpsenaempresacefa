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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero', 20)->unique();
            $table->string('tipo', 20);
            $table->string('estado', 20)->default('radicada');
            $table->unsignedInteger('documento_id')->nullable();
            $table->string('nombre_propuesto', 200)->nullable();
            $table->unsignedSmallInteger('proceso_id');
            $table->unsignedSmallInteger('area_id');
            $table->unsignedTinyInteger('tipo_doc_id')->nullable();
            $table->text('justificacion');
            $table->text('descripcion_cambio')->nullable();
            $table->string('adjunto_ruta', 500)->nullable();
            $table->unsignedInteger('solicitado_por');
            $table->unsignedInteger('asignado_a')->nullable();
            $table->text('observaciones_resp')->nullable();
            $table->timestamp('fecha_radicacion')->useCurrent();
            $table->timestamp('fecha_resolucion')->nullable();
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent();

            $table->foreign('documento_id')->references('id')->on('documentos')->nullOnDelete();
            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('tipo_doc_id')->references('id')->on('tipos_documento');
            $table->foreign('solicitado_por')->references('id')->on('usuarios');
            $table->foreign('asignado_a')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
