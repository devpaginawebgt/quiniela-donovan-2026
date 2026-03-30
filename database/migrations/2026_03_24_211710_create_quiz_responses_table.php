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
        Schema::create('quiz_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_user_id')
                ->constrained('quiz_user', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('quiz_question_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('quiz_option_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->boolean('is_correct');
            $table->integer('points_received');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_responses');
    }
};
