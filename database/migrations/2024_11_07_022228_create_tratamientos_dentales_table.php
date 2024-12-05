<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTratamientosDentalesTable extends Migration
{
    public function up()
    {
        Schema::create('tratamientos_dentales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Campo para el nombre del tratamiento
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tratamientos_dentales');
    }
}
