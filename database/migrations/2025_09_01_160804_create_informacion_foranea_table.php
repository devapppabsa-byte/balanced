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
        Schema::create('informacion_foranea', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_info');
            $table->string('contenido');
            $table->string('descripcion');
            $table->string('tipo_dato');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_foranea');
    }
};
