<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAvTipotransporte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_tipotransporte', function (Blueprint $table) {
            $table->increments('ttrans_id');
            $table->string('tipotransporte',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('av_tipotransporte');
    }
}
