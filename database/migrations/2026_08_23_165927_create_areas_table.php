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
        Schema::create('areas', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 120);
            $table->unsignedSmallInteger('proceso_id')->nullable();
            $table->tinyInteger('activo')->default(1);
            $table->timestamp('creado_en')->useCurrent();

            $table->foreign('proceso_id')->references('id')->on('procesos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
