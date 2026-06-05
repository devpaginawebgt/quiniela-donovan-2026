<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_team_id')->unique();
            $table->string('name');
            $table->string('code', 10)->nullable();
            $table->string('country')->nullable();
            $table->unsignedSmallInteger('founded')->nullable();
            $table->boolean('national')->default(false);
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_teams');
    }
};
