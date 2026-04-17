<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bracket_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journey_id')->constrained('jornadas')->onUpdate('cascade')->onDelete('restrict');
            $table->smallInteger('bracket_position');

            $table->foreignId('team_one_id')->nullable()->constrained('equipos')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('team_two_id')->nullable()->constrained('equipos')->onUpdate('cascade')->onDelete('set null');

            $table->foreignId('result_id')->nullable()->constrained('resultado_partidos')->onUpdate('cascade')->onDelete('set null');

            $table->tinyInteger('status')->default(0);

            $table->foreignId('local_game_id')->nullable()->constrained('bracket_games')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('visitor_game_id')->nullable()->constrained('bracket_games')->onUpdate('cascade')->onDelete('set null');

            $table->string('local_slot_label', 8)->nullable();
            $table->string('visitor_slot_label', 8)->nullable();

            $table->string('local_source', 10)->default('ganador');
            $table->string('visitor_source', 10)->default('ganador');

            $table->timestamps();

            $table->unique(['journey_id', 'bracket_position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bracket_games');
    }
};
