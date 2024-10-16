<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicosTable extends Migration
{
    public function up()
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->foreignId('especialidad_id')->constrained('especialidades');
            $table->foreignId('sexo_id')->constrained('sexos');
            $table->string('password');
            $table->string('dui')->unique();
            $table->integer('edad');
            $table->string('LicenseNumber', 4)->unique();  // 4 números
            $table->string('address', 255);  // Dirección con máximo 255 caracteres
            $table->string('phone', 8);  // Teléfono con exactamente 8 caracteres
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('medicos');
    }
}
