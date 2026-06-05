<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partidos', function (Blueprint $table) {
            $table->foreignId('api_fixture_id')
                ->nullable()
                ->unique()
                ->after('brand_id')
                ->constrained('api_fixtures', 'api_fixture_id')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('partidos', function (Blueprint $table) {
            $table->dropForeign(['api_fixture_id']);
            $table->dropUnique(['api_fixture_id']);
            $table->dropColumn('api_fixture_id');
        });
    }
};
