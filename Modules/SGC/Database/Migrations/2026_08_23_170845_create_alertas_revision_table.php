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
        Schema::create('alertas_revision', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('documento_id');
            $table->unsignedInteger('version_id');
            $table->tinyInteger('dias_restantes');
            $table->unsignedInteger('notificado_a');
            $table->tinyInteger('activa')->default(1);
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('resuelta_en')->nullable();

            $table->foreign('documento_id')->references('id')->on('documentos')->cascadeOnDelete();
            $table->foreign('version_id')->references('id')->on('versiones_doc')->cascadeOnDelete();
            $table->foreign('notificado_a')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas_revision');
    }
};
