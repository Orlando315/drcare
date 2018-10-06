<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status', 10)->default('Inactivo');
            $table->string('role', 10)->default('Usuario');
            $table->string('nombre');
            $table->string('tipo_cedula', 1);
            $table->string('cedula', 10)->unique();
            $table->unsignedInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->unsignedInteger('cargo_id');
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voida
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
