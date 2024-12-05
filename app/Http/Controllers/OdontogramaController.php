<?php

namespace App\Http\Controllers;

use App\Models\HallazgosClinicos;
use Illuminate\Http\Request;
use App\Models\Tratamiento;
use App\Models\Odontograma;
use App\Models\OdontogramaInicial;
use App\Models\Patient;
use App\Models\TratamientoDental;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Asegúrate de que esta línea esté presente

class OdontogramaController extends Controller
{
    
    public function index()
{
    // Obtener todos los pacientes
    $pacientes = Patient::all();
    // Obtener todos los hallazgos clínicos
    $hallazgos_clinicos = Tratamiento::all(); // Cambié la variable a $hallazgos_clinicos
    // Obtener todos los odontogramas para la vista inicial
    $odontogramas = Odontograma::with('patient')->distinct('paciente_id')->get()->unique('paciente_id');
    return view('admin.odontograma.index', compact('odontogramas', 'pacientes', 'hallazgos_clinicos')); // Cambié $hallazgo a $hallazgos_clinicos
}

    
public function create()
{
    // Obtener todos los pacientes sin restricciones
    $pacientes = Patient::all(); // Mostrar todos los pacientes, no solo los que tienen odontogramas

    // Obtener todos los tratamientos (mantener el modelo Tratamiento)
    $tratamientos = Tratamiento::all(); // Variable correctamente definida para obtener los tratamientos

    // Obtener todos los tratamientos dentales (modelo TratamientoDental)
    $tratamientos_dentales = TratamientoDental::all(); // Obtener los tratamientos dentales

    // Pasar la lista de pacientes, tratamientos y tratamientos dentales a la vista
    return view('admin.odontograma.create', compact('pacientes', 'tratamientos', 'tratamientos_dentales'));
}




public function store(Request $request)
{
    // Ver los datos que se están recibiendo
    //dd($request->all()); 

    // Validación de los datos para odontograma
    $request->validate([
        'paciente_id' => 'required|exists:patients,id', // Valida el paciente
        'tratamiento_id' => 'required|exists:tratamientos,id', // Valida el tratamiento
        'dientes' => 'required|array', // Valida los dientes
        'presion_arterial' => 'nullable|string|regex:/^\d+\/\d+$/', // Validación para presión arterial en formato '120/80'
        'pulso' => 'nullable|string|regex:/^\d+ bpm$/', // Validación para pulso en formato '75 bpm'
        'temperatura' => 'nullable|string|regex:/^\d+(\.\d+)?°C$/', // Validación para temperatura en formato '37°C'
        'motivo_consulta' => 'required|string', // Valida que el motivo de consulta sea una cadena
        'tratamiento_dental_id' => 'nullable|exists:tratamientos_dentales,id', // Valida que el tratamiento dental sea válido (opcional)
        'diagnostico' => 'nullable|string', // Valida que el diagnóstico sea una cadena (opcional)
        'tratamiento_propuesto' => 'nullable|string', // Valida que el tratamiento propuesto sea una cadena (opcional)
        'observaciones' => 'nullable|string', // Valida que las observaciones sean una cadena (opcional)
    ]);

    // Obtiene el id del paciente y tratamiento (odontograma)
    $pacienteId = $request->input('paciente_id');
    $tratamientoId = $request->input('tratamiento_id');

    // Procesar los datos de los dientes (para odontograma)
    $dientes = $request->input('dientes');

    // Guarda los datos en la tabla odontograma
    foreach ($dientes as $numeroDiente => $areas) {
        foreach ($areas as $area => $tratamiento_id) {
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

    // Guarda la consulta en la tabla consultas, incluyendo los nuevos campos
    DB::table('consultas')->insert([
        'patient_id' => $pacienteId, // Relacionado con el paciente
        'tratamiento_dental_id' => $request->input('tratamiento_dental_id'), // Tratamiento dental (si lo tiene)
        'motivo_consulta' => $request->input('motivo_consulta'), // Motivo de la consulta
        'diagnostico' => $request->input('diagnostico'), // Diagnóstico
        'tratamiento_propuesto' => $request->input('tratamiento_propuesto'), // Tratamiento propuesto
        'observaciones' => $request->input('observaciones'), // Observaciones
        'presion_arterial' => $request->input('presion_arterial'), // Presión Arterial
        'pulso' => $request->input('pulso'), // Pulso
        'temperatura' => $request->input('temperatura'), // Temperatura
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // Redirige al índice de odontogramas con un mensaje de éxito
    return redirect()->route('admin.odontograma.index')->with('success', 'Datos guardados correctamente.');
}




    public function show($id)
    {
        // Buscar el odontograma por su ID
        $odontograma = Odontograma::findOrFail($id);
        
        // Obtener el paciente relacionado al odontograma
        $paciente = $odontograma->patient;
        
        // Obtener los tratamientos asociados al paciente y al odontograma
        $tratamientos = Odontograma::where('paciente_id', $paciente->id)
            ->join('tratamientos', 'odontograma.tratamiento_id', '=', 'tratamientos.id')
            ->select('diente', 'area', 'tratamientos.color')
            ->get();

        // Retornar la vista, enviando los datos del paciente, odontograma y tratamientos
        return view('admin.odontograma.show', compact('paciente', 'odontograma', 'tratamientos'));
    }

    public function odontogramaInicial($id)
    {
        // Buscar el odontograma inicial por su ID
        $odontogramaInicial = OdontogramaInicial::findOrFail($id);
        
        // Obtener el paciente relacionado al odontograma inicial
        $paciente = $odontogramaInicial->patient;
        
        // Obtener los tratamientos asociados al paciente y al odontograma inicial
        $tratamientos = OdontogramaInicial::where('paciente_id', $paciente->id)
            ->join('tratamientos', 'odontograma_inicial.tratamiento_id', '=', 'tratamientos.id')
            ->select('diente', 'area', 'tratamientos.color')
            ->get();
    
        // Retornar la vista, enviando los datos del paciente, odontograma inicial y tratamientos
        return view('admin.odontograma.odontograma_inicial', compact('paciente', 'odontogramaInicial', 'tratamientos'));
    }
    

    public function destroy($paciente_id)
    {
        // Elimina todos los registros relacionados en la tabla 'odontograma' con el paciente_id específico
        $deletedRows = DB::table('odontograma')->where('paciente_id', $paciente_id)->delete();
    
        // Verifica si se eliminaron filas
        if ($deletedRows > 0) {
            return redirect()->route('admin.odontograma.index')->with('success', 'Registros eliminados correctamente.');
        } else {
            return redirect()->route('admin.odontograma.index')->with('error', 'No se encontraron registros para eliminar.');
        }
    }


    
    
    public function imprimir()
{
    // Obtener todos los odontogramas y agruparlos por paciente_id
    $odontogramas = Odontograma::with('patient')
        ->select('paciente_id', DB::raw('MIN(id) as id')) // Obtener el id mínimo para cada paciente
        ->groupBy('paciente_id')
        ->get();

    // Generar el PDF
    $pdf = PDF::loadView('admin.odontograma.pdf', compact('odontogramas'));

    // Descargar el PDF
    return $pdf->download('odontogramas.pdf');
}
    
public function pacienteOdontogramaImprimir($id)
    {
        // Recuperar el paciente por ID
        $paciente = Patient::findOrFail($id);
        // Suponiendo que tienes tratamientos asociados al paciente
        $tratamientos = $paciente->tratamientos; // Ajusta según tu relación

        // Generar el PDF usando la vista 'admin.odontograma.odontograma-paciente-pdf'
        $pdf = PDF::loadView('admin.odontograma.odontograma-paciente-pdf', [
            'paciente' => $paciente,
            'tratamientos' => $tratamientos
        ]);

        // Retornar el PDF como respuesta
        return $pdf->download('odontograma_' . $paciente->nombres . '.pdf');
    }

    public function buscarPacientes(Request $request)
    {
        $query = $request->input('query');
        $pacientes = Patient::where('nombres', 'like', '%' . $query . '%')
            ->orWhere('apellidos', 'like', '%' . $query . '%')
            ->get();
    
        return response()->json($pacientes);
    }


    public function searchPatients(Request $request)
{
    $search = $request->input('search');

    // Buscar pacientes por nombres o apellidos, y verificar relación en odontograma
    $patients = Patient::where('nombres', 'like', "%{$search}%")
        ->orWhere('apellidos', 'like', "%{$search}%")
        ->whereHas('odontograma') // Solo pacientes con registros en odontograma
        ->get(['id', 'nombres', 'apellidos']);

    return response()->json($patients);
}
    
    



  

}
