<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_result_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('partido_id')->unique()
                ->constrained('partidos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedBigInteger('api_fixture_id')->index();

            $table->string('status', 16)->default('pending')->index();
            $table->timestamp('scheduled_at')->index();

            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('last_attempted_at')->nullable();
            $table->string('last_status_short', 8)->nullable();
            $table->string('last_status_long')->nullable();
            $table->unsignedTinyInteger('last_goals_home')->nullable();
            $table->unsignedTinyInteger('last_goals_away')->nullable();
            $table->string('last_error')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_result_requests');
    }
};
