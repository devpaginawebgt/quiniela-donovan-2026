<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('codigos', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('codigo')->unique();
        //     $table->integer('estado')->default(0);
        //     // $table->integer('id_dependiente')->default(0);
        //     // $table->string('nombre_dependiente');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codigos');
    }
}
