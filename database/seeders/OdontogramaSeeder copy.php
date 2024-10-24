<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Odontograma;
use App\Models\Patient;
use App\Models\Tratamiento; // Asegúrate de importar el modelo Tratamiento

class OdontogramaSeeder extends Seeder
{
    public function run()
    {
        // Asegurarte de que existan los pacientes
        $patients = Patient::all();
        if ($patients->isEmpty()) {
            // Crear algunos pacientes
            $patients = [
                ['name' => 'Paciente 1', 'email' => 'paciente1@example.com'],
                ['name' => 'Paciente 2', 'email' => 'paciente2@example.com'],
            ];
            foreach ($patients as $patient) {
                Patient::create($patient);
            }
            $patients = Patient::all(); // Obtener nuevamente los pacientes creados
        }

        // Asegurarte de que existan los tratamientos
        $tratamientos = Tratamiento::all();
        if ($tratamientos->isEmpty()) {
            // Crear algunos tratamientos
            $tratamientos = [
                ['nombre' => 'Tratamiento 1'],
                ['nombre' => 'Tratamiento 2'],
                ['nombre' => 'Tratamiento 3'],
                ['nombre' => 'Tratamiento 4'],
            ];
            foreach ($tratamientos as $tratamiento) {
                Tratamiento::create($tratamiento);
            }
        }

        // Crear los odontogramas
        $odontogramas = [
            ['patient_id' => 1, 'diente' => '1', 'area' => 'superior', 'tratamiento_id' => 2],
            // ... (Resto de tus datos de odontograma)
        ];

        foreach ($odontogramas as $odontograma) {
            Odontograma::create($odontograma);
        }
    }
}
