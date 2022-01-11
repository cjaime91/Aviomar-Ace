<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAvCotLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_cot_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cot_id')->nullable();
            $table->foreign('cot_id', 'fk_cotizacion_log')->references('cot_id')->on('av_cotizaciones')->onDelete('restrict')->onUpdate('restrict');
            $table->date('fecha');
            $table->string('tipo', 25);
            $table->unsignedInteger('usuario_id')->nullable();
            $table->foreign('usuario_id', 'fk_cotizacion_log_usuario')->references('id')->on('av_usuarios')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('av_cot_logs');
    }
}
