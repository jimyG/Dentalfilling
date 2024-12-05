<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTratamientosTable extends Migration
{
    public function up()
    {
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id(); // auto-incremental por defecto
            $table->string('nombre', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tratamientos');
    }
}
