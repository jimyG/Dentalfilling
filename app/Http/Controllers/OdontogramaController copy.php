<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Tratamiento;
use App\Models\Odontograma;
use App\Models\Patient;

class OdontogramaController extends Controller
{
    public function index()
    {
        $pacientes = Patient::all();// Obtener todos los pacientes
        $tratamientos = Tratamiento::all(); // Obtener todos los tratamientos

        return view('admin.odontograma.index', compact('pacientes', 'tratamientos'));
    }

    public function store(Request $request)
    {
        $paciente_id = $request->input('paciente_id');
        $dientes = $request->input('dientes');

        foreach ($dientes as $diente => $areas) {
            foreach ($areas as $area => $tratamiento_id) {
                // Verificar si ya existe un registro para este diente y área
                $odontograma = Odontograma::where('paciente_id', $paciente_id)
                                          ->where('diente', $diente)
                                          ->where('area', $area)
                                          ->first();

                if ($odontograma) {
                    // Si ya existe, actualizar el tratamiento
                    $odontograma->update(['tratamiento_id' => $tratamiento_id]);
                } else {
                    // Si no existe, crear un nuevo registro
                    Odontograma::create([
                        'paciente_id' => $paciente_id,
                        'diente' => $diente,
                        'area' => $area,
                        'tratamiento_id' => $tratamiento_id
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Odontograma guardado correctamente.');
    }
}
