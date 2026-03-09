<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();
            $table->string('fase')->nullable();
            $table->unsignedBigInteger('jornada_id');
            $table->dateTime('fecha_partido')->index();
            $table->unsignedBigInteger('estadio_id');
            $table->integer('jugado')->default(0);
            $table->integer('estado')->index()->default(0);
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->timestamps();

            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('estadio_id')
                ->references('id')
                ->on('estadios')
                ->onUpdate('cascade')
                ->onDelete('restrict');
                
            $table->foreign('jornada_id')
                ->references('id')
                ->on('jornadas')
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
        Schema::dropIfExists('partidos');
    }
}
