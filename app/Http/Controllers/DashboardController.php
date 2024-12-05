<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\Patient; // Asegúrate de que la ruta al modelo sea correcta
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     
    
    public function calendarData()
    {
        // Obtener el mes y año actual
        $currentMonth = Carbon::now()->format('F Y'); // Formato "Mes Año", por ejemplo "November 2024"
        $currentYear = Carbon::now()->year;
        $currentMonthNumber = Carbon::now()->month;

        // Obtener las consultas del mes actual
        $consultas = Consulta::whereYear('created_at', $currentYear)
                             ->whereMonth('created_at', $currentMonthNumber)
                             ->get();

        // Agrupar las consultas por día
        $consultasByDay = $consultas->groupBy(function ($consulta) {
            return Carbon::parse($consulta->created_at)->format('d'); // Agrupar por día
        });

        // Pasar las variables a la vista
        return view('admin.dashboard', compact('currentMonth', 'consultasByDay'));
    } 
    
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

    

public function getRecentPatients(Request $request)
{
    $filter = $request->input('filter', 'week'); // Por defecto "week"

    switch ($filter) {
        case 'day':
            $startDate = Carbon::now()->startOfDay();
            break;
        case '3days':
            $startDate = Carbon::now()->subDays(3);
            break;
        case 'week':
            $startDate = Carbon::now()->subWeek();
            break;
        case 'month':
            $startDate = Carbon::now()->subMonth();
            break;
        case '3months':
            $startDate = Carbon::now()->subMonths(3);
            break;
        case 'year':
            $startDate = Carbon::now()->subYear();
            break;
        default:
            $startDate = null;
            break;
    }

    $query = Patient::select(DB::raw('DATE(fecha_ingreso) as date'), 'genero', DB::raw('count(*) as total'))
        ->groupBy('date', 'genero')
        ->orderBy('date', 'asc');

    if ($startDate) {
        $query->where('fecha_ingreso', '>=', $startDate);
    }

    $patients = $query->get();

    return response()->json($patients);
}


public function getFrequentTreatments(Request $request)
{
    // Obtener el filtro desde la solicitud
    $filter = $request->query('filter', 'week'); // Default a 'week'

    // Establecer el rango de fechas según el filtro
    $startDate = now(); // Fecha actual

    switch ($filter) {
        case 'day':
            $startDate = now()->startOfDay();
            break;
        case '3days':
            $startDate = now()->subDays(3);
            break;
        case 'week':
            $startDate = now()->subWeek();
            break;
        case 'month':
            $startDate = now()->subMonth();
            break;
        case '3months':
            $startDate = now()->subMonths(3);
            break;
        case 'year':
            $startDate = now()->subYear();
            break;
        default:
            $startDate = now()->subWeek(); // Default a 'week'
            break;
    }

    // Obtener los tratamientos más frecuentes en base al rango de fechas
    $treatments = DB::table('odontograma')
        ->join('tratamientos', 'odontograma.tratamiento_id', '=', 'tratamientos.id')
        ->select('tratamientos.nombre', DB::raw('count(*) as total'))
        ->where('odontograma.created_at', '>=', $startDate) // Filtrar por fecha
        ->groupBy('tratamientos.nombre')
        ->orderBy('total', 'desc')
        ->limit(5) // Limitar a los 5 tratamientos más frecuentes
        ->get();

    return response()->json($treatments);
}



    
}
