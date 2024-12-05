<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enfermedades_comunes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('hipertension')->nullable();
            $table->string('diabetes')->nullable();
            $table->string('hemofilia')->nullable();
            $table->string('tumor_labio')->nullable();
            $table->string('medicamento')->nullable();
            $table->string('tumor_cervico')->nullable();
            $table->string('sindrome_down')->nullable();
            $table->string('tumor_mama')->nullable();
            $table->string('tumor_pulmon')->nullable();
            $table->string('autismo')->nullable();
            $table->string('tumor_colon')->nullable();
            $table->string('tumor_estomago')->nullable();
            $table->string('paralisis')->nullable();
            $table->string('erc')->nullable();
            $table->string('cardiopatia')->nullable();
            $table->string('endocarditis')->nullable();
            $table->string('otros')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enfermedades_comunes');
    }
};
