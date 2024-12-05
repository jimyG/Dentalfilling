<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); // Relación con pacientes
            $table->foreignId('tratamiento_dental_id')->nullable()->constrained('tratamientos_dentales')->onDelete('set null'); // Relación con tratamientos_dentales
            $table->text('motivo_consulta')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento_propuesto')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}
