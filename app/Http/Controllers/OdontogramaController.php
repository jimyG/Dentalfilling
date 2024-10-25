<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tratamiento;
use App\Models\Odontograma;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Asegúrate de que esta línea esté presente

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
    // Obtener todos los pacientes sin restricciones
    $pacientes = Patient::all(); // Mostrar todos los pacientes, no solo los que tienen odontogramas

    // Obtener todos los tratamientos
    $tratamientos = Tratamiento::all();

    // Pasar la lista de pacientes y tratamientos a la vista
    return view('admin.odontograma.create', compact('pacientes', 'tratamientos'));
}



public function store(Request $request)
{
    // Valida los datos
    $request->validate([
        'paciente_id' => 'required|exists:patients,id',
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



}
