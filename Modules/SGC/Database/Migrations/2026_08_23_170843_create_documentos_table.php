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
        Schema::create('documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->unsignedSmallInteger('proceso_id');
            $table->unsignedSmallInteger('area_id');
            $table->unsignedTinyInteger('tipo_doc_id');
            $table->unsignedInteger('responsable_id');
            $table->string('estado', 20)->default('borrador');
            $table->date('fecha_elaboracion');
            $table->date('fecha_proxima_revision')->nullable();
            $table->timestamp('fecha_publicacion')->nullable();
            $table->timestamp('fecha_obsolescencia')->nullable();
            $table->unsignedInteger('creado_por');
            $table->timestamp('creado_en')->useCurrent();
            $table->timestamp('actualizado_en')->useCurrent();

            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('tipo_doc_id')->references('id')->on('tipos_documento');
            $table->foreign('responsable_id')->references('id')->on('usuarios');
            $table->foreign('creado_por')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
