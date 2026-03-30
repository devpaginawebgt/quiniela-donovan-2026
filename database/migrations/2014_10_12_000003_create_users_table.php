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

            $table->unsignedBigInteger('codigo_id')->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('numero_documento');
            $table->string('telefono');
            $table->string('email')->unique();

            $table->integer('puntos_trivias')->default(0);
            $table->integer('puntos_predicciones')->default(0);
            $table->integer('puntos')->index()->default(0);

            $table->unsignedBigInteger('pais_id');
            $table->string('direccion');

            // Campos doctor
            $table->string('colegiado')->nullable();
            $table->string('region')->nullable();
            $table->string('capital')->nullable();
            $table->unsignedBigInteger('visitor_id')->nullable();

            // Campos dependiente
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('branch')->nullable();

            $table->unsignedBigInteger('user_type_id');
            $table->integer('status_user')->index()->default(1);

            $table->string('password');
            $table->string('accepted_terms_version');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('codigo_id')
                ->references('id')
                ->on('codigos')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('user_type_id')
                ->references('id')
                ->on('user_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('visitor_id')
                ->references('id')
                ->on('visitors')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            // $table->foreign('branch_id')
            //     ->references('id')
            //     ->on('branches')
            //     ->onUpdate('cascade')
            //     ->onDelete('restrict');
                
            $table->foreign('pais_id')
                ->references('id')
                ->on('countries')
                ->onUpdate('cascade')
                ->onDelete('restrict');
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