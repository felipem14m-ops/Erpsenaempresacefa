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
        Schema::create('listado_maestro', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('documento_id')->unique();
            $table->unsignedInteger('version_id');
            $table->unsignedSmallInteger('proceso_id');
            $table->unsignedInteger('publicado_por');
            $table->timestamp('fecha_pub')->useCurrent();
            $table->tinyInteger('activo')->default(1);

            $table->foreign('documento_id')->references('id')->on('documentos');
            $table->foreign('version_id')->references('id')->on('versiones_doc');
            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->foreign('publicado_por')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listado_maestro');
    }
};
