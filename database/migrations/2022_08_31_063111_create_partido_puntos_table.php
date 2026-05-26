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
        Schema::create('partido_puntos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partido_id')
                ->constrained('partidos')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('acerto_marcadores');
            $table->integer('acerto_ganador');
            $table->integer('acerto_empate');
            $table->integer('default')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partido_puntos');
    }
};
