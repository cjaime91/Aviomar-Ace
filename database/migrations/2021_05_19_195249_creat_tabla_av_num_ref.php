<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatTablaAvNumRef extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_num_ref', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('toper_id');
            $table->foreign('toper_id', 'fk_num_ref_oper')->references('toper_id')->on('av_tipooperacion')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('tcliente_id');
            $table->foreign('tcliente_id', 'fk_num_ref_cliente')->references('tcliente_id')->on('av_tipocliente')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('producto_id');
            $table->foreign('producto_id', 'fk_num_ref_productos')->references('producto_id')->on('av_productos')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('num_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_num_ref');
    }
}
