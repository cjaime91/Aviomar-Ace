<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAvCiudad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_ciudades', function (Blueprint $table) {
            $table->increments('ciudad_id');
            $table->string('ciudad',50);
            $table->string('cod_pais');
            $table->foreign('cod_pais','fk_ciudad_paises')->references('cod')->on('av_paises')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_ciudades');
    }
}
