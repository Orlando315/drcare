<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('productos', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users');
        $table->unsignedInteger('productos_categorias_id');
        $table->foreign('productos_categorias_id')->references('id')->on('productos_categorias');
        $table->string('nombre', 100);
        $table->string('imagen', 100)->nullable();
        $table->string('etiqueta', 100)->nullable();
        $table->string('descripcion', 300)->nullable();
        $table->string('indicaciones', 300)->nullable();
        /* --- Codigos ---*/
        $table->string('codigo_producto', 30);
        $table->string('codigo_barra', 30);
        $table->string('codigo_barra_imagen', 100)->nullable();
        /* --- Hojas ---*/
        $table->string('hoja_tecnica_seguridad', 100)->nullable();
        $table->string('permiso_sanitario', 100)->nullable();
        /* --- Produccion ---*/
        $table->float('peso', 10, 2);
        $table->float('volumen', 10, 2);
        $table->string('subempaque', 30);
        $table->string('empaque_master', 30);
        $table->unsignedInteger('cantidad_paleta');
        /* --- Informacion arancelaria ---*/
        $table->string('declaracion_jurada', 100)->nullable();
        $table->string('cpe', 100)->nullable();
        $table->date('cpe_expiracion')->nullable();
        $table->string('codigo_arancelario', 100)->nullable();

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
      Schema::dropIfExists('productos');
    }
}
