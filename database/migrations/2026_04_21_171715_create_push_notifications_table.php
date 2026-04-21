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
        Schema::create('push_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('image_path')->nullable();
            $table->integer('user_type_id')->nullable();
            $table->foreignId('country_id')
                ->nullable()
                ->constrained('countries')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->integer('recipients')->default(0);
            $table->boolean('success')->default(false);
            $table->integer('failed')->default(0);
            $table->string('comment')->nullable();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->boolean('from_system')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('push_notifications');
    }
};
