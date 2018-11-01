<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosArtesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('productos_artes', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('producto_id');
        $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        $table->unsignedInteger('productos_carpetas_id')->nullable();
        $table->foreign('productos_carpetas_id')->references('id')->on('productos_carpetas')->onDelete('cascade');
        $table->unsignedInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users');
        $table->string('nombre', 100)->nullable();
        $table->string('path', 100)->nullable();
        $table->string('mime', 30);
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
      Schema::dropIfExists('productos_artes');
    }
}
