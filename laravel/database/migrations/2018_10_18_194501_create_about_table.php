<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about', function (Blueprint $table) {
          $table->increments('id');
          $table->string('email', 50)->nullable();
          $table->string('rif', 100)->nullable();
          $table->date('rif_expiracion')->nullable();
          $table->string('registro_mercantil', 100)->nullable();
          $table->date('registro_mercantil_expiracion')->nullable();
          $table->string('patente_industria', 100)->nullable();
          $table->date('patente_industria_expiracion')->nullable();
          $table->string('racda', 100)->nullable();
          $table->date('racda_expiracion')->nullable();
          $table->string('solvencia_ss', 100)->comment('Solvencia Seguro Social')->nullable();
          $table->date('solvencia_ss_expiracion')->nullable();
          $table->string('solvencia_ince', 100)->nullable();
          $table->date('solvencia_ince_expiracion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('about');
    }
}
