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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->string('url');
            $table->string('url_web')->nullable();

            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
