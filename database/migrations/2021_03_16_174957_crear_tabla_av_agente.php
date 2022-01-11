<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAvAgente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_agentes', function (Blueprint $table) {
            $table->increments('agente_id');
            $table->string('codigo', 40);
            $table->string('razon_social', 255);
            $table->string('email', 60)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('telefono', 100)->nullable();
            $table->string('celular', 40)->nullable();
            $table->string('cod_pais')->nullable();
            $table->foreign('cod_pais', 'fk_pais_agente')->references('cod')->on('av_paises')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('ciudad_id')->nullable();
            $table->foreign('ciudad_id', 'fk_ciudad_agente')->references('ciudad_id')->on('av_ciudades')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('estado_id')->default(9);
            $table->foreign('estado_id', 'fk_estado_agente')->references('estado_id')->on('av_estados')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('av_agentes');
    }
}
