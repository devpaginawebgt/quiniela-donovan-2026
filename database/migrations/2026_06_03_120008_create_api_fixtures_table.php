<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_fixtures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_fixture_id')->unique();

            $table->unsignedInteger('league_id')->index();
            $table->unsignedSmallInteger('season')->index();
            $table->string('round')->index();

            $table->unsignedBigInteger('api_home_team_id')->index();
            $table->unsignedBigInteger('api_away_team_id')->index();

            $table->timestamp('date')->nullable();
            $table->string('timezone', 64)->nullable();

            $table->string('status_short', 8)->nullable()->index();
            $table->string('status_long')->nullable();

            $table->unsignedTinyInteger('goals_home')->nullable();
            $table->unsignedTinyInteger('goals_away')->nullable();

            $table->unsignedTinyInteger('ft_goals_home')->nullable();
            $table->unsignedTinyInteger('ft_goals_away')->nullable();
            $table->unsignedTinyInteger('et_goals_home')->nullable();
            $table->unsignedTinyInteger('et_goals_away')->nullable();
            $table->unsignedTinyInteger('pt_goals_home')->nullable();
            $table->unsignedTinyInteger('pt_goals_away')->nullable();

            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_fixtures');
    }
};
