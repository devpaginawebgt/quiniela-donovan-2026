<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Campos requeridos
            // $table->unsignedBigInteger('codigo_id')->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('numero_documento')->nullable()->index();
            $table->string('telefono')->nullable();
            $table->string('email')->unique();

            $table->integer('puntos_predicciones_grupos')->default(0);
            $table->integer('puntos_trivias_grupos')->default(0);
            $table->integer('puntos_bonus_grupos')->default(0);
            $table->integer('puntos_grupos')->index()->default(0);

            $table->integer('puntos_predicciones')->default(0);
            $table->integer('puntos_trivias')->default(0);
            $table->integer('puntos_bonus')->default(0);
            $table->integer('puntos')->index()->default(0);

            $table->foreignId('pais_id')
                ->constrained('countries')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('direccion')->nullable();

            // Campos doctor
            $table->string('colegiado')->nullable();
            $table->string('region')->nullable();
            $table->foreignId('visitor_id')
                ->nullable()
                ->constrained('visitors')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Campos dependiente
            $table->foreignId('company_id')
                ->nullable()
                ->constrained('companies')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('branch')->nullable();

            $table->string('puesto')->nullable();

            $table->foreignId('user_type_id')
                ->constrained('user_types')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->integer('status_user')->index()->default(1);

            $table->string('password');
            $table->string('accepted_terms_version')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}