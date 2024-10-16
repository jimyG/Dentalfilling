<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdontogramasTable extends Migration
{
    public function up()
    {
        Schema::create('odontogramas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('diente');
            $table->string('estado');
            $table->string('cuadrante'); // Cuadrante (superior, inferior, etc.)
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('odontogramas');
    }
}
