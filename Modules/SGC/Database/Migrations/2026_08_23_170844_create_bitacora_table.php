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
       Schema::create('bitacora', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('usuario_id')->nullable();
            $table->string('accion', 40);
            $table->string('modulo', 60);
            $table->string('entidad', 60)->nullable();
            $table->integer('entidad_id')->nullable();
            $table->text('descripcion');
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->string('resultado', 15)->default('exitoso');
            $table->timestamp('registrado_en')->useCurrent();

            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};
