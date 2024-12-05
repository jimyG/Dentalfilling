<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\EvaluacionRegional;
use Barryvdh\DomPDF\PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\View\View;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function search(Request $request)
    {
        $search = $request->input('search');

        // Realiza la búsqueda en la base de datos
        $pacientes = Patient::where('nombres', 'LIKE', '%' . $search . '%')
                        ->orWhere('apellidos', 'LIKE', '%' . $search . '%')
                        ->get();

        // Devuelve los resultados como JSON
        return response()->json($pacientes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $validatedData = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:masculino,femenino',
            'estado_civil' => 'required|in:soltero,casado,viudo,divorciado',
            'telefono' => 'nullable|numeric',
            'celular' => 'nullable|numeric',
            'correo' => 'nullable|email',
            'whatsapp' => 'nullable|numeric',
            'emergencia_contacto' => 'nullable|string|max:255',
            'emergencia_telefono' => 'nullable|numeric',
            'ha_visitado_odontologo' => 'required|boolean',
            'historia_enfermedad' => 'required|string|max:255',
            'historia_medica_personal' => 'required|string|max:255',
            'antecedentes_medicos_familiares' => 'required|string|max:255'
        ]);

        // Generar el número de expediente automáticamente
        $expediente = Patient::max('expediente') + 1; // Asumiendo que tienes un campo 'expediente' en la tabla

        // Calcular la edad
        $age = Carbon::parse($request->fecha_nacimiento)->age;

        // Crear el paciente
        $patient = Patient::create([
            'expediente' => 'EXP-' . str_pad(Patient::count() + 1, 6, '0', STR_PAD_LEFT), // Número de expediente único y autoincrementable
            'fecha_ingreso' => now(),
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'edad' => $age,
            'estado_civil' => $request->estado_civil,
            'telefono' => $request->telefono,
            'celular' => $request->celular,
            'correo' => $request->correo,
            'whatsapp' => $request->whatsapp,
            'emergencia_contacto' => $request->emergencia_contacto,
            'emergencia_telefono' => $request->emergencia_telefono,
            'ha_visitado_odontologo' => $request->ha_visitado_odontologo,
            'historia_enfermedad' => $request->historia_enfermedad,
            'historia_medica_personal' => $request->historia_medica_personal,
            'antecedentes_medicos_familiares' => $request->antecedentes_medicos_familiares,
        ]);
        $patient->save(); // Guardar el paciente en la base de datos

        return redirect()->route('patients.index')->with('success', 'Paciente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Obtener el paciente junto con sus relaciones
        $paciente = Patient::with([
            'consultas.tratamientosDentales',  // Cargar la relación de consultas y tratamientos dentales
            'signosVitales',
            'examenesClinicos',
            'evaluacionSistemica',
            'evaluacionRegional',
            'enfermedadesComunes',
            'odontograma'  // Asegúrate de cargar la relación odontograma
        ])->findOrFail($id);
    
        // Verificar si el paciente tiene un odontograma
        $tieneOdontograma = $paciente->odontograma ? true : false;
    
        // Pasar el paciente y la variable de verificación a la vista
        return view('admin.patient.show', compact('paciente', 'tieneOdontograma'));
    }
    public function __construct()
    {
        $this->pdf = PDF::class;  // Asegúrate de que $this->pdf esté correctamente asignado
    }

    public function report($id)
    {
        // Cargar paciente con las relaciones necesarias
        $paciente = Patient::with([
            'consultas.tratamientosDentales',
            'signosVitales',
            'examenesClinicos',
            'evaluacionSistemica',
            'evaluacionRegional',
            'enfermedadesComunes',
            'odontograma'
        ])->findOrFail($id);
    
        // Inicializar la variable $noDatos
        $noDatos = false;
    
        // Verificar si alguna de las relaciones está vacía o no existe
        if (($paciente?->consultas && $paciente->consultas->isEmpty()) || 
            ($paciente->signosVitales && $paciente->signosVitales->isEmpty()) || 
            ($paciente->examenesClinicos && $paciente->examenesClinicos->isEmpty()) || 
            ($paciente->evaluacionSistemica && $paciente->evaluacionSistemica->isEmpty()) || 
            ($paciente->evaluacionRegional && $paciente->evaluacionRegional->isEmpty()) || 
            !$paciente->enfermedadesComunes || 
            ($paciente->odontograma && $paciente->odontograma->isEmpty())) {  
            $noDatos = true;
        }
    
        // Pasar la variable $noDatos a la vista
        $pdfView = view('admin.patient.patient_report_id', compact('paciente', 'noDatos'))->render();
    
        // Inicializar Dompdf y generar el PDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfView);
        $dompdf->render();
    
        return $dompdf->stream('reporte_paciente_' . $paciente->id . '.pdf', ['Attachment' => true]);
    }
        

    


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Cargar al paciente con sus relaciones
        $paciente = Patient::with(['evaluacionSistemica', 'signosVitales', 'examenesClinicos', 'evaluacionRegional'])->findOrFail($id);
        $paciente = Patient::with('evaluacionRegional')->findOrFail($id);
        return view('admin.patient.edit', compact('paciente'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos entrantes
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string',
            'estado_civil' => 'required|string',
            'telefono' => 'nullable|numeric',
            'celular' => 'nullable|numeric',
            'correo' => 'nullable|email',
            'whatsapp' => 'nullable|numeric',
            'emergencia_contacto' => 'nullable|string|max:255',
            'emergencia_telefono' => 'nullable|numeric',
            'ha_visitado_odontologo' => 'required|boolean',
            'historia_enfermedad' => 'nullable|string',
            'historia_medica_personal' => 'nullable|string',
            'antecedentes_medicos_familiares' => 'nullable|string',
            // Validación para signos vitales
            'pa' => 'nullable|string|max:50',
            'pulso' => 'nullable|string|max:50',
            'temperatura' => 'nullable|string|max:50',
            // Validar solo si se envían nuevas regiones
            'regiones' => 'nullable|array',
            'regiones.*.region' => 'nullable|string|max:255',
            'regiones.*.condicion' => 'nullable|string|max:255',
            'regiones.*.observacion' => 'nullable|string',
        ]);

        // Buscar al paciente por su ID
        $paciente = Patient::findOrFail($id);

        // Actualizar los datos del paciente
        $paciente->update([
            'nombres' => $request->input('nombres'),
            'apellidos' => $request->input('apellidos'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'genero' => $request->input('genero'),
            'estado_civil' => $request->input('estado_civil'),
            'telefono' => $request->input('telefono'),
            'celular' => $request->input('celular'),
            'correo' => $request->input('correo'),
            'whatsapp' => $request->input('whatsapp'),
            'emergencia_contacto' => $request->input('emergencia_contacto'),
            'emergencia_telefono' => $request->input('emergencia_telefono'),
            'ha_visitado_odontologo' => $request->input('ha_visitado_odontologo'),
        ]);

        // Actualizar la evaluación sistémica si existe
        $evaluacionSistemica = $paciente->evaluacionSistemica()->first();
        if ($evaluacionSistemica) {
            $evaluacionSistemica->update([
                'historia_enfermedad' => $request->input('historia_enfermedad'),
                'historia_medica_personal' => $request->input('historia_medica_personal'),
                'antecedentes_medicos_familiares' => $request->input('antecedentes_medicos_familiares'),
            ]);
        }


        // Actualizar los signos vitales si existen
        $signosVitales = $paciente->signosVitales()->first();
        if ($signosVitales) {
            $signosVitales->update([
                'pa' => $request->input('pa'),
                'pulso' => $request->input('pulso'),
                'temperatura' => $request->input('temperatura'),
            ]);
        }

         // Actualizar los exámenes clínicos
    if ($paciente->examenesClinicos->isEmpty()) {
        // Si no existe un examen clínico, creamos uno nuevo
        $paciente->examenesClinicos()->create([
            'examen_extraoral' => $request->input('examen_extraoral'),
            'examen_intraoral' => $request->input('examen_intraoral'),
        ]);
    } else {
        // Si ya existe un examen clínico, actualizamos
        $paciente->examenesClinicos->first()->update([
            'examen_extraoral' => $request->input('examen_extraoral'),
            'examen_intraoral' => $request->input('examen_intraoral'),
        ]);
    }

        // Solo actualizar las regiones si se han enviado nuevas regiones en la solicitud
if ($request->has('regiones')) {
    $regiones = $request->input('regiones', []);

    foreach ($regiones as $regionData) {
        // Verificar que el array contenga el campo 'region'
        if (isset($regionData['region'])) {
            // Buscar si ya existe una evaluación para esa región
            $evaluacionRegional = $paciente->evaluacionRegional()
                                           ->where('region', $regionData['region'])
                                           ->first();

            if ($evaluacionRegional) {
                // Actualizar la evaluación existente
                $evaluacionRegional->update([
                    'condicion' => $regionData['condicion'] ?? null,
                    'observacion' => $regionData['observacion'] ?? null,
                ]);
            } else {
                // Si no existe, crear una nueva evaluación para esa región
                $paciente->evaluacionRegional()->create([
                    'region' => $regionData['region'],
                    'condicion' => $regionData['condicion'] ?? null,
                    'observacion' => $regionData['observacion'] ?? null,
                ]);
            }
        }
    }
}


        // Redirigir de nuevo a la vista de edición con un mensaje de éxito
        return redirect()->route('admin.patient.index', $paciente->id)
            ->with('success', 'El paciente ha sido actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patient.index')->with('success', 'Paciente eliminado exitosamente.');
        
    }

    public function destroyRegion($pacienteId, $regionId)
{
    // Encuentra la evaluación regional por su ID y la elimina
    $evaluacion = EvaluacionRegional::where('patient_id', $pacienteId)->where('id', $regionId)->first();

    if ($evaluacion) {
        $evaluacion->delete();
        return redirect()->back()->with('success', 'Región eliminada correctamente.');
    } else {
        return redirect()->back()->with('error', 'Región no encontrada.');
    }
}
public function removeRegion($pacienteId, $regionId)
{
    $paciente = Patient::findOrFail($pacienteId);
    $region = $paciente->evaluacionRegional()->findOrFail($regionId);

    // Eliminar la región
    $region->delete();

    return redirect()->route('admin.patient.edit', $paciente->id)
                     ->with('success', 'Región eliminada correctamente.');
}

}
