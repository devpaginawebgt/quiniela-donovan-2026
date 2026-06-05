<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jornadas', function (Blueprint $table) {
            $table->string('api_round')->nullable()->after('name');
            $table->unsignedInteger('fixtures')->default(0)->after('api_round');
            $table->unsignedInteger('fixtures_pending_date')->default(0)->after('fixtures');
            $table->boolean('completed')->default(false)->after('fixtures_pending_date');
        });
    }

    public function down(): void
    {
        Schema::table('jornadas', function (Blueprint $table) {
            $table->dropColumn(['api_round', 'fixtures', 'fixtures_pending_date', 'completed']);
        });
    }
};
