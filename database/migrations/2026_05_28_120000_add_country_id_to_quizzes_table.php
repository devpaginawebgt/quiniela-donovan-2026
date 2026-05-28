<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreignId('country_id')
                ->nullable()
                ->default(1)
                ->after('ranking_tab_id')
                ->constrained('countries')
                ->onUpdate('cascade')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('country_id');
        });
    }
};
