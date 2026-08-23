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
        Schema::create('versiones_doc', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('documento_id');
            $table->string('numero_version', 20);
            $table->text('descripcion_cambio');
            $table->string('archivo_ruta', 500);
            $table->string('archivo_nombre', 255);
            $table->integer('archivo_tamano_kb')->nullable();
            $table->string('archivo_formato', 10)->default('pdf');
            $table->string('estado', 20)->default('borrador');
            $table->unsignedInteger('publicado_por')->nullable();
            $table->timestamp('fecha_publicacion')->nullable();
            $table->timestamp('fecha_obsolescencia')->nullable();
            $table->unsignedInteger('creado_por');
            $table->timestamp('creado_en')->useCurrent();

            $table->unique(['documento_id', 'numero_version']);
            $table->foreign('documento_id')->references('id')->on('documentos')->cascadeOnDelete();
            $table->foreign('publicado_por')->references('id')->on('usuarios');
            $table->foreign('creado_por')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versiones_doc');
    }
};
