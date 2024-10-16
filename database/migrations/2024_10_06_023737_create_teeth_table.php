<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeethTable extends Migration
{
    public function up()
    {
        Schema::create('teeth', function (Blueprint $table) {
            $table->id(); // ID del diente, generará un campo `id` de tipo BIGINT AUTO_INCREMENT
            $table->string('name'); // Nombre del diente (ej. "Incisivo", "Canino", etc.)
            $table->unsignedTinyInteger('position'); // Posición del diente en la boca
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('teeth'); // Eliminar tabla si se hace un rollback
    }
}
