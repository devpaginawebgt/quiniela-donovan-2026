<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_player_id')->unique();
            $table->unsignedBigInteger('api_team_id')->index();
            $table->string('name');
            $table->unsignedSmallInteger('age')->nullable();
            $table->unsignedSmallInteger('number')->nullable();
            $table->string('position')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_players');
    }
};
