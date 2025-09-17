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
        Schema::create('input_vacio', function (Blueprint $table) {
            $table->id();
            $table->string("id_input");
            $table->string('nombre');
            $table->string('tipo');
            $table->string('informacion_llenada')->nullable();
            $table->string('descripcion')->nullable()->default('Sin descripción disponible');

            $table->unsignedBigInteger('id_indicador');
            $table->foreign('id_indicador')
                  ->references('id')
                  ->on('indicadores')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_vacio');
    }
};
