<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsentimientosInformadosTable extends Migration
{
    public function up()
    {
        Schema::create('consentimientos_informados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('medicos');
            $table->foreignId('patient_id')->constrained('patients');
            $table->text('contenido');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consentimientos_informados');
    }
}
