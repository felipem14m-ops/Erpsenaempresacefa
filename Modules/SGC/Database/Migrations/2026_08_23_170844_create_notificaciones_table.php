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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('usuario_id');
            $table->string('tipo', 40); // ej: solicitud_aprobada, solicitud_rechazada, alerta_revision
            $table->string('titulo', 150);
            $table->text('mensaje');
            $table->string('entidad', 60)->nullable(); // solicitudes, documentos, etc.
            $table->integer('entidad_id')->nullable();
            $table->tinyInteger('leida')->default(0);
            $table->timestamp('leida_en')->nullable();
            $table->timestamp('creado_en')->useCurrent();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
