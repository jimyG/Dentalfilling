<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tratamiento;
use App\Models\Odontograma;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class OdontogramaController extends Controller
{
    public function index()
    {
        // Cargar odontogramas con la relación de paciente
        $odontogramas = Odontograma::with('patient')->get(); // Cambia 'paciente' a 'patient'
    
        // Obtener todos los pacientes
        $pacientes = Patient::all();
        // Obtener todos los tratamientos
        $tratamientos = Tratamiento::all();
    
        // Asegúrate de pasar $odontogramas a la vista
        return view('admin.odontograma.index', compact('odontogramas', 'pacientes', 'tratamientos'));
    }
    
    public function create()
{
    // Cargar odontogramas con la relación de paciente
    $odontogramas = Odontograma::with('patient')->get(); // Carga todos los odontogramas

    // Obtener IDs de pacientes únicos asociados a odontogramas
    $pacienteIds = $odontogramas->pluck('paciente_id')->unique(); // Obtén IDs únicos

    // Obtener solo los pacientes únicos basados en los IDs obtenidos
    $pacientes = Patient::whereIn('id', $pacienteIds)->get();

    // Obtener todos los tratamientos
    $tratamientos = Tratamiento::all();

    // Pasar la lista de odontogramas, pacientes y tratamientos a la vista
    return view('admin.odontograma.create', compact('odontogramas', 'pacientes', 'tratamientos'));
}



    public function store(Request $request)
    {
        // Valida los datos
        $request->validate([
            'paciente_id' => 'required|exists:patients,id', // Cambia 'pacientes' a 'patients'
            'tratamiento_id' => 'required|exists:tratamientos,id',
            'dientes' => 'required|array'
        ]);

        // Obtiene el id del paciente y tratamiento
        $pacienteId = $request->input('paciente_id');
        $tratamientoId = $request->input('tratamiento_id');
        
        // Procesar los datos de los dientes
        $dientes = $request->input('dientes');

        foreach ($dientes as $numeroDiente => $areas) {
            foreach ($areas as $area => $tratamiento_id) {
                // Guarda cada tratamiento en la base de datos
                DB::table('odontograma')->insert([
                    'paciente_id' => $pacienteId,
                    'tratamiento_id' => $tratamiento_id,
                    'diente' => $numeroDiente,
                    'area' => $area,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Datos guardados correctamente.');
    }
}
