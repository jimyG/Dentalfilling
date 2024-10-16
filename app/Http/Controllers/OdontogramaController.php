<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class OdontogramaController extends Controller
{
    public function guardar(Request $request)
    {
        $odontograma = $request->input('odontograma');

        foreach ($odontograma as $diente) {
            // Aquí puedes guardar los datos en la base de datos
            // Por ejemplo, usando el modelo 'Odontograma' o similar
            \DB::table('odontogramas')->insert([
                'diente' => $diente['diente'],
                'estado' => $diente['estado'],
                'patient_id' => auth()->user()->id  // Relacionar con el paciente
            ]);
        }

        return response()->json(['message' => 'Odontograma guardado correctamente']);
    }

    public function index($patientId)
    {
        // Recupera el paciente por su ID
        $patient = Patient::find($patientId);

        // Verifica si el paciente existe
        if (!$patient) {
            return redirect()->back()->with('error', 'Paciente no encontrado.');
        }

        // Pasa el paciente a la vista
        return view('admin.odontograma.index', compact('patient'));
    }
}
