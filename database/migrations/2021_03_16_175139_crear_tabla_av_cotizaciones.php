<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAvCotizaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_cotizaciones', function (Blueprint $table) {
            $table->increments('cot_id');
            $table->string('consecutivo_mn')->nullable();
            $table->string('consecutivo_expo', 14)->nullable();
            $table->string('consecutivo_impo', 14)->nullable();
            $table->unsignedInteger('usuario_ejecutivo_id');
            $table->foreign('usuario_ejecutivo_id', 'fk_cotizacion_usuario')->references('id')->on('av_usuarios')->onDelete('restrict')->onUpdate('restrict');
            $table->date('fecha');
            $table->integer('agente_id_c')->nullable();
            $table->integer('agente_id_o')->nullable();
            $table->double('valor_o', 20, 2)->nullable();
            $table->integer('agente_id_d')->nullable();
            $table->double('valor_d', 20, 2)->nullable();
            $table->string('cliente', 150)->nullable();
            $table->string('empresa', 150)->nullable();
            $table->string('facturar_a', 255)->nullable();
            $table->unsignedInteger('sucursal_id')->nullable();
            $table->foreign('sucursal_id', 'fk_cotizacion_sucursal')->references('sucursal_id')->on('av_sucursal')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('toper_id')->nullable();
            $table->foreign('toper_id', 'fk_cotizacion_operacion')->references('toper_id')->on('av_tipooperacion')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('tcliente_id')->nullable();
            $table->foreign('tcliente_id', 'fk_cotizacion_tipocliente')->references('tcliente_id')->on('av_tipocliente')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('producto_id')->nullable();
            $table->foreign('producto_id', 'fk_cotizacion_producto')->references('producto_id')->on('av_productos')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('num_ref')->nullable();
            $table->unsignedInteger('ttrans_id')->nullable();
            $table->foreign('ttrans_id', 'fk_cotizacion_tipotransporte')->references('ttrans_id')->on('av_tipotransporte')->onDelete('restrict')->onUpdate('restrict');
            $table->double('cbm_a', 20, 2)->nullable();
            $table->double('libras_a', 20, 2)->nullable();
            $table->double('cbm_m', 20, 2)->nullable();
            $table->double('libras_m', 20, 2)->nullable();
            $table->double('cbm', 20, 2)->nullable();
            $table->double('libras', 20, 2)->nullable();
            $table->unsignedInteger('ciudad_id_or')->nullable();
            $table->foreign('ciudad_id_or', 'fk_cotizacion_ciudad_or')->references('ciudad_id')->on('av_ciudades')->onDelete('restrict')->onUpdate('restrict');
            $table->string('cod_pais_or')->nullable();
            $table->foreign('cod_pais_or', 'fk_cotizacion_pais_or')->references('cod')->on('av_paises')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('ciudad_id_ds')->nullable();
            $table->foreign('ciudad_id_ds', 'fk_cotizacion_ciudad_ds')->references('ciudad_id')->on('av_ciudades')->onDelete('restrict')->onUpdate('restrict');
            $table->string('cod_pais_ds')->nullable();
            $table->foreign('cod_pais_ds', 'fk_cotizacion_pais_ds')->references('cod')->on('av_paises')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('usuario_realiza_id')->nullable();
            $table->foreign('usuario_realiza_id', 'fk_cotizacion_usuario_r')->references('id')->on('av_usuarios')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedInteger('estado_id')->nullable()->default(4);
            $table->foreign('estado_id', 'fk_cotizacion_estado')->references('estado_id')->on('av_estados')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('av_cotizaciones');
    }
}
