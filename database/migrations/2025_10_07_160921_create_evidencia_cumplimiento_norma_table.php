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
        Schema::create('evidencia_cumplimiento_norma', function (Blueprint $table) {
            $table->id();
            $table->string('evidencia');
            $table->unsignedBigInteger('id_cumplimiento_norma');
            $table->foreign('id_cumplimiento_norma')
                  ->references('id')
                  ->on('cumplimiento_norma')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencia_cumplimiento_norma');
    }
};
