<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sexos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // 'Masculino' o 'Femenino'
            $table->timestamps();
        });

        // Insertar datos
        DB::table('sexos')->insert([
            ['nombre' => 'Masculino'],
            ['nombre' => 'Femenino'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sexos');
    }
};
