<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAvNotascot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_notascot', function (Blueprint $table) {
            $table->increments('nota_id');
            $table->unsignedInteger('cot_id');
            $table->date('fecha');
            $table->foreign('cot_id', 'fk_comentario_cot')->references('cot_id')->on('av_cotizaciones')->onDelete('restrict')->onUpdate('restrict');
            $table->string('comentario', 255);
            $table->unsignedInteger('usuario_com_id');
            $table->foreign('usuario_com_id', 'fk_usuario_com')->references('id')->on('av_usuarios')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('av_notascot');
    }
}
