<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\Patient; // Asegúrate de que la ruta al modelo sea correcta
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getCounts()
    {
        
        // Contar doctores, pacientes y especialidades
    $doctorCount = Medico::count(); // Contar doctores
    $patientCount = Patient::count(); // Contar pacientes
    $specialtyCount = Especialidad::count(); // Contar especialidades

    // Retornar el conteo en formato JSON
    return response()->json([
        'doctors' => $doctorCount,
        'patients' => $patientCount,
        'specialties' => $specialtyCount, // Asegúrate de incluir este conteo
    ]);
    }
}
