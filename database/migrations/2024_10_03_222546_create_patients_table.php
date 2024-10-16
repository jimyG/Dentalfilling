<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('patients')) {
            Schema::create('patients', function (Blueprint $table) {
                // Definición de la tabla aquí
            });
        }
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('expediente')->nullable();
            $table->date('fecha_ingreso');
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->string('genero');
            $table->integer('edad');
            $table->string('estado_civil');
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('correo')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('emergencia_contacto')->nullable();
            $table->string('emergencia_telefono')->nullable();
            $table->boolean('ha_visitado_odontologo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
}


















