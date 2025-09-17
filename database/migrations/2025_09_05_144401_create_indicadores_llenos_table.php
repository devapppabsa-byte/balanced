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
        Schema::create('indicadores_llenos', function (Blueprint $table) {

            $table->id();
            $table->string("nombre_campo");
            $table->string("informacion_campo");
            $table->unsignedBigInteger('id_indicador');

            $table->foreign('id_indicador')
                  ->references('id')
                  ->on('indicadores');
                  
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indocadores_llenos');
    }
};
