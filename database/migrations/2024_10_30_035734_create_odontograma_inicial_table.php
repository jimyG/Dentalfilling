<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdontogramaInicialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odontograma_inicial', function (Blueprint $table) {
            $table->id(); // auto-incremental por defecto
            $table->foreignId('paciente_id')->constrained('patients')->onDelete('cascade'); // Referencia a la tabla patients
            $table->string('diente', 10)->nullable();
            $table->string('area', 10)->nullable();
            $table->foreignId('tratamiento_id')->constrained('tratamientos'); // relación con tratamientos
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
        Schema::dropIfExists('odontograma_inicial');
    }
}
