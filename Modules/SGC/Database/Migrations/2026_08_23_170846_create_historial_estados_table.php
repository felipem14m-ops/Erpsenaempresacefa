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
        Schema::create('historial_estados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('documento_id');
            $table->unsignedInteger('version_id')->nullable();
            $table->string('estado_anterior', 20)->nullable();
            $table->string('estado_nuevo', 20);
            $table->text('observaciones')->nullable();
            $table->unsignedInteger('cambiado_por');
            $table->timestamp('cambiado_en')->useCurrent();

            $table->foreign('documento_id')->references('id')->on('documentos')->cascadeOnDelete();
            $table->foreign('version_id')->references('id')->on('versiones_doc')->nullOnDelete();
            $table->foreign('cambiado_por')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_estados');
    }
};
