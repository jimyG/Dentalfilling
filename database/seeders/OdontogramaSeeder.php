<?php

// database/seeders/OdontogramaSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Odontograma;
use App\Models\Patient;

class OdontogramaSeeder extends Seeder
{
    public function run()
    {  
        // Asegurarte de que existan los pacientes
        $patients = Patient::all();
        if ($patients->isEmpty()) {
            // Crear algunos pacientes
            $patients = [
                ['nombres' => 'Paciente 1', 'correo' => 'paciente1@example.com'],
                ['nombres' => 'Paciente 2', 'correo' => 'paciente2@example.com'],
            ];
            foreach ($patients as $patient) {
                Patient::create($patient);
            }
            $patients = Patient::all(); // Obtener nuevamente los pacientes creados
        }
        $odontogramas = [
            ['patient_id' => 1, 'diente' => '1', 'area' => 'superior', 'tratamiento_id' => 2],
            ['patient_id' => 1, 'diente' => '1', 'area' => 'izquierda', 'tratamiento_id' => 2],
            ['patient_id' => 1, 'diente' => '1', 'area' => 'centro', 'tratamiento_id' => 2],
            ['patient_id' => 1, 'diente' => '1', 'area' => 'derecha', 'tratamiento_id' => 2],
            ['patient_id' => 1, 'diente' => '1', 'area' => 'inferior', 'tratamiento_id' => 2],
            ['patient_id' => 1, 'diente' => '2', 'area' => 'superior', 'tratamiento_id' => 4],
            ['patient_id' => 1, 'diente' => '2', 'area' => 'izquierda', 'tratamiento_id' => 4],
            ['patient_id' => 1, 'diente' => '2', 'area' => 'centro', 'tratamiento_id' => 4],
            ['patient_id' => 1, 'diente' => '2', 'area' => 'derecha', 'tratamiento_id' => 4],
            ['patient_id' => 1, 'diente' => '2', 'area' => 'inferior', 'tratamiento_id' => 4],
            ['patient_id' => 1, 'diente' => '3', 'area' => 'superior', 'tratamiento_id' => 3],
            ['patient_id' => 1, 'diente' => '3', 'area' => 'izquierda', 'tratamiento_id' => 3],
            ['patient_id' => 1, 'diente' => '3', 'area' => 'centro', 'tratamiento_id' => 3],
            ['patient_id' => 1, 'diente' => '3', 'area' => 'derecha', 'tratamiento_id' => 3],
            ['patient_id' => 1, 'diente' => '3', 'area' => 'inferior', 'tratamiento_id' => 3],
            ['patient_id' => 2, 'diente' => '1', 'area' => 'superior', 'tratamiento_id' => 1],
            ['patient_id' => 2, 'diente' => '1', 'area' => 'centro', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '1', 'area' => 'izquierda', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '1', 'area' => 'derecha', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '1', 'area' => 'inferior', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '2', 'area' => 'inferior', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '2', 'area' => 'izquierda', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '2', 'area' => 'centro', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '2', 'area' => 'derecha', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '2', 'area' => 'superior', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '3', 'area' => 'superior', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '3', 'area' => 'izquierda', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '3', 'area' => 'centro', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '3', 'area' => 'derecha', 'tratamiento_id' => 4],
            ['patient_id' => 2, 'diente' => '3', 'area' => 'inferior', 'tratamiento_id' => 4],
        ];

        foreach ($odontogramas as $odontograma) {
            Odontograma::create($odontograma);
        }
    }
}
