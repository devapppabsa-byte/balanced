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
        Schema::create('evidencias_quejas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_archivo');
            $table->string('evidencia');
            $table->unsignedBigInteger('id_queja');
            $table->foreign('id_queja')
                  ->references('id')
                  ->on('quejas')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias_quejas');
    }
};
