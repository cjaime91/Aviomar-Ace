<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaAvUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usuario', 30);
            $table->string('nombre', 50)->nullable();
            $table->string('apellidos', 50)->nullable();
            $table->string('email', 100)->unique();
            $table->boolean('estado')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 60);
            $table->unsignedInteger('rol_id');
            $table->foreign('rol_id', 'fk_usuario_rol')->references('rol_id')->on('av_roles')->onDelete('restrict')->onUpdate('restrict');
            $table->rememberToken();
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
        Schema::dropIfExists('av_usuarios');
    }
}
