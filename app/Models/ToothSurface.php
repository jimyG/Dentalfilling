<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToothSurfacesTable extends Migration
{
    public function up()
    {
        Schema::create('tooth_surfaces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tooth_id'); // ID del diente al que pertenece
            $table->enum('surface', ['mesial', 'distal', 'occlusal', 'vestibular', 'lingual']); // Superficie seleccionada
            $table->boolean('selected')->default(false); // Indica si esta superficie está seleccionada
            $table->timestamps();

            $table->foreign('tooth_id')->references('id')->on('teeth')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tooth_surfaces');
    }
}
