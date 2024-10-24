<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdontogramaTable extends Migration
{
    public function up()
{
    Schema::create('odontograma', function (Blueprint $table) {
        $table->id(); // auto-incremental por defecto
        $table->foreignId('paciente_id')->constrained('patients')->onDelete('cascade'); // Referencia a la tabla patients
        $table->string('diente', 10)->nullable();
        $table->string('area', 10)->nullable();
        $table->foreignId('tratamiento_id')->constrained('tratamientos'); // relación con tratamientos
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('odontograma');
    }
}
