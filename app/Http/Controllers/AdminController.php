<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\EnfermedadesComunes;
use App\Models\User;
use App\Models\Role;
use App\Models\Patient;
use App\Models\Sexo;
use App\Models\Especialidad;
use App\Models\EvaluacionSistemica;
use App\Models\SignosVitales;
use App\Models\EvaluacionClinica;
use App\Models\EvaluacionRegional; // Asegúrate de importar el modelo
use App\Models\ExamenesClinicos;
use App\Models\Medico;
use App\Models\Odontograma;
use App\Models\TratamientoDental;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;




class AdminController extends Controller
{

    //Contadores
    public function dashboard()
    {
        // Contar el número de médicos y pacientes
        $doctorCount = Medico::count();
        $patientCount = Patient::count();

        // Pasar las variables a la vista
        return view('admin.dashboard', compact('doctorCount', 'patientCount'));
    }



    // Formulario para crear usuario
    public function createUserForm()
    {
        return view('admin.usuarios.create-user');
    }

    // Crear usuario
    public function createUser(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:Administrador,Médico,Paciente',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', $request->role)->first();
        if ($role) {
            $user->roles()->attach($role);
        }

        return redirect()->route('admin.usuarios.manage-users')->with('success', 'Usuario creado exitosamente.');
    }

    // Eliminar usuario
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Usuario no encontrado.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
        
    }

    //Formulario para crear Medicos:
    // Método index para listar los médicos
    public function index()
    {
        // Recupera todos los médicos con su especialidad
        $medicos = Medico::with('especialidad')->paginate(3);

        // Retorna la vista con la lista de médicos
        return view('admin.doctor.index', compact('medicos'));
    }

    public function printDoctors()
{
    // Obtener los datos de los médicos
    $medicos = Medico::all();
    
    // Generar el PDF con la vista y los datos
    $pdf = PDF::loadView('admin.doctor.report_medico', compact('medicos'))
              ->setPaper('A4', 'landscape')  // Establecer orientación horizontal (landscape)
              ->setOption('isHtml5ParserEnabled', true)  // Habilitar HTML5 para mejor interpretación de las etiquetas
              ->setOption('isPhpEnabled', true)         // Habilitar PHP dentro del PDF
              ->setOption('dpi', 150)                  // Ajustar resolución del PDF para mejor calidad
              ->setOption('font', 'Arial');            // Establecer fuente para el contenido
    
    // Forzar descarga del PDF sin abrir una nueva pestaña
    return response($pdf->output())
           ->header('Content-Type', 'application/pdf')
           ->header('Content-Disposition', 'attachment; filename="reporte_medicos.pdf"');
}

    

    public function create()
    {
        // Recuperar especialidades y sexos para el formulario
        $especialidades = Especialidad::all(); // Obtener todas las especialidades
        $sexos = Sexo::all(); // Obtener todas las opciones de sexo

    return view('admin.doctor.create', compact('especialidades', 'sexos'));
    }

    public function store(Request $request)
    {
        // Validación de los datos
        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:medicos,email',
        'especialidad_id' => 'required|exists:especialidades,id',
        'sexo_id' => 'required|exists:sexos,id',
        'password' => 'required|min:8|confirmed', // Asegura que la confirmación de la contraseña coincida
        'dui' => 'required|string|max:10|unique:medicos,dui',
        'edad' => 'required|integer|min:18',
        'LicenseNumber' => 'required|string|unique:medicos,LicenseNumber|max:4', // Verifica la unicidad
        'address' => 'required|string|max:255',
        'phone' => 'required|string|size:8', // Asume que el teléfono tiene 8 dígitos
    ], [
        'dui.unique' => 'El DUI ingresado ya está en uso. Por favor, ingresa otro.',
        'LicenseNumber.unique' => 'El número de licencia ingresado ya está en uso. Por favor, ingresa otro.', // Mensaje personalizado
        'LicenseNumber.unique' => 'El número de licencia ingresado ya está en uso. Por favor, ingresa otro.',
        'email.unique' => 'El email ingresado ya está en uso. Por favor, ingresa otro.'
    ]);

        // Crear nuevo médico
        $medico = new Medico();
        $medico->name = $validatedData['name'];
        $medico->email = $validatedData['email'];
        $medico->especialidad_id = $validatedData['especialidad_id'];
        $medico->sexo_id = $validatedData['sexo_id'];
        $medico->password = bcrypt($validatedData['password']); // Encriptar contraseña
        $medico->dui = $validatedData['dui'];
        $medico->edad = $validatedData['edad'];
        $medico->LicenseNumber = $validatedData['LicenseNumber'];
        $medico->address = $validatedData['address'];
        $medico->phone = $validatedData['phone'];
        $medico->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.doctor.index')->with('success', 'Médico creado con éxito.');
    }

    // Método para generar el PDF
    // Método para generar el PDF
    public function generarPDF()
    {
        // Obtiene todas las especialidades
        $especialidades = Especialidad::all();

        // Cargar la vista y pasarle las especialidades
        $pdfView = view('admin.especialidades.reporte_especialidades', compact('especialidades'))->render();

        // Inicializar Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Cargar el contenido HTML
        $dompdf->loadHtml($pdfView);

        // Configurar tamaño y orientación
        $dompdf->setPaper('A4', 'landscape'); // Cambia 'landscape' a 'portrait' si prefieres vertical

        // Renderizar el PDF
        $dompdf->render();

        // Salida del PDF (puedes cambiar a false para ver en el navegador)
        return $dompdf->stream('reporte_especialidades.pdf', ['Attachment' => true]);
    }

    public function editDoctor($id)
{
    $medico = Medico::findOrFail($id);
    $especialidades = Especialidad::all(); // Asegúrate de tener una lista de especialidades si es necesario
    $sexos = Sexo::all(); // Asegúrate de obtener los datos de la tabla de sexos
    return view('admin.doctor.edit', compact('medico', 'especialidades', 'sexos'));

}


public function updateDoctor(Request $request, $id)
{
    // Validación de los datos
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:medicos,email,' . $id,
        'especialidad_id' => 'required|exists:especialidades,id',
        'sexo_id' => 'required|exists:sexos,id',
        'password' => 'nullable|min:8|confirmed',  // El campo 'password_confirmation' debe coincidir
        'dui' => 'required|string|max:10',
        'edad' => 'required|integer|min:18',
        'LicenseNumber' => 'required|string|max:50',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
    ]);

    // Obtener el médico
    $medico = Medico::findOrFail($id);

    // Actualizar la contraseña solo si se ha proporcionado
    if ($request->filled('password')) {
        $medico->password = bcrypt($request->password);
    }

    // Actualizar otros campos
    $medico->update($request->except('password')); // Excluye 'password' si no se llena

    return redirect()->route('admin.doctor.index')->with('success', 'Médico actualizado exitosamente.');
}


public function destroyDoctor($id)
{
    $medico = Medico::findOrFail($id);
    $medico->delete();
    return redirect()->route('admin.doctor.index')->with('success', 'Médico eliminado exitosamente.');
}



public function generatePdf()
{
    // Obtener todos los pacientes
    $pacientes = Patient::all();

    // Crear una instancia de PDF y generar el archivo utilizando la vista 'patient_report.blade.php'
    $pdf = PDF::loadView('admin.patient.patient_report', compact('pacientes'))
        ->setPaper('a4', 'landscape'); // Cambia a 'landscape' para orientación horizontal

    // Descargar el archivo PDF
    return $pdf->download('reporte_pacientes.pdf');
}

    // Formulario para crear paciente

    // Función para listar los pacientes
    public function indexPaciente()
    {
        $pacientes = Patient::paginate(10)->through(function ($paciente) {
            $paciente->tiene_odontograma = Odontograma::where('paciente_id', $paciente->id)->exists();
            return $paciente;
        });
    
        return view('admin.patient.index', compact('pacientes'));
    }

    public function show($id)
{
    $odontograma = Odontograma::where('paciente_id', $id)->firstOrFail();

    return view('admin.odontograma.show', compact('odontograma'));
}



    
    // Función para mostrar el formulario de creación de paciente
    public function createPaciente()
    {
        // Puedes pasarle datos necesarios a la vista si es necesario
        return view('admin.patient.create');
    }

    public function searchPaciente(Request $request)
    {
        // Validar el término de búsqueda
        $request->validate([
            'search' => 'required|string|min:1',
        ]);
    
        // Obtener el término de búsqueda
        $searchTerm = $request->input('search');
    
        // Realizar la búsqueda de pacientes de forma optimizada
        $pacientes = Patient::select('id', 'nombres', 'apellidos', 'correo', 'fecha_nacimiento')
                            ->where('nombres', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('apellidos', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('correo', 'LIKE', "%{$searchTerm}%")
                            ->paginate(10);
    
        // Para cada paciente, verificamos si tiene un odontograma
        $pacientes->through(function ($paciente) {
            // Verificar si el paciente tiene odontograma
            $paciente->tiene_odontograma = Odontograma::where('paciente_id', $paciente->id)->exists();
            return $paciente;
        });
    
        // Retornar la vista con los resultados
        return view('admin.patient.index', compact('pacientes'));
    }
    


    public function destroyRegion($patientId, $regionId)
    {
        // Buscar la evaluación regional específica del paciente y la región
        $evaluacionRegional = EvaluacionRegional::where('patient_id', $patientId)
            ->where('id', $regionId)
            ->first();

        // Verificar si se encontró
        if (!$evaluacionRegional) {
            return redirect()->route('admin.patient.index')->with('error', 'Región no encontrada.');
        }

        // Eliminar la región
        $evaluacionRegional->delete();

        return redirect()->route('admin.patient.index')->with('success', 'Región eliminada exitosamente.');
    }
// En AdminController.php
public function destroyPaciente($id)
{
    // Lógica para eliminar el paciente con ID $id
    $paciente = Patient::findOrFail($id);
    $paciente->delete();

    return redirect()->route('admin.patient.index')->with('success', 'Paciente eliminado correctamente');
    
}

public function storePaciente(Request $request)
{
    // Validación de los campos requeridos y opcionales
    $validated = $request->validate([
        'expediente' => 'nullable|string|max:255',
        'fecha_ingreso' => 'required|date',
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'dui' => 'required|string|regex:/^[0-9]{8}-[0-9]$/',
        'fecha_nacimiento' => 'required|date',
        'genero' => 'required|string|in:masculino,femenino',
        'edad' => 'required|integer',
        'estado_civil' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:15',
        'direccion' => 'required|string|max:255',
        'celular' => 'nullable|string|max:15',
        'correo' => 'nullable|email|max:255',
        'whatsapp' => 'nullable|string|max:15',
        'emergencia_contacto' => 'nullable|string|max:255',
        'emergencia_telefono' => 'nullable|string|max:15',
        'ha_visitado_odontologo' => 'required|boolean',
        'historia_enfermedad' => 'nullable|string',
        'historia_medica_personal' => 'nullable|string',
        'antecedentes_medicos_familiares' => 'nullable|string',
        'pa' => 'nullable|string|max:10',
        'pulso' => 'nullable|string|max:10',
        'temperatura' => 'nullable|string|max:10',
        'examen_extraoral' => 'nullable|string',
        'examen_intraoral' => 'nullable|string',
        'region' => 'nullable|string',
        'condicion' => 'required|string|in:normal,anormal,no_acepta_revision',
        'observacion' => 'nullable|string',
        'hipertension' => 'nullable|string',
        'diabetes' => 'nullable|string',
        'hemofilia' => 'nullable|string',
        'tumor_labio' => 'nullable|string',
        'medicamento' => 'nullable|string',
        'tumor_cervico' => 'nullable|string',
        'sindrome_down' => 'nullable|string',
        'tumor_mama' => 'nullable|string',
        'tumor_pulmon' => 'nullable|string',
        'autismo' => 'nullable|string',
        'tumor_colon' => 'nullable|string',
        'tumor_estomago' => 'nullable|string',
        'paralisis' => 'nullable|string',
        'erc' => 'nullable|string',
        'cardiopatia' => 'nullable|string',
        'endocarditis' => 'nullable|string',
        'otros' => 'nullable|string',
    ], 
    // Mensajes personalizados para los campos requeridos
    [
        'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
        'nombres.required' => 'El campo de nombres es obligatorio.',
        'apellidos.required' => 'El campo de apellidos es obligatorio.',
        'dui.required' => 'El DUI es obligatorio y debe seguir el formato 12345678-9.',
        'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
        'genero.required' => 'El género es obligatorio y debe ser masculino o femenino.',
        'edad.required' => 'La edad es obligatoria.',
        'estado_civil.required' => 'El estado civil es obligatorio.',
        'direccion.required' => 'La dirección es obligatoria.',
        'ha_visitado_odontologo.required' => 'El campo "¿Ha visitado odontólogo?" es obligatorio.',
        'condicion.required' => 'La condición del paciente es obligatoria.',
    ]);

    DB::beginTransaction();

    try {// Guardar el paciente
        $paciente = new Patient();
        $paciente->expediente = $validated['expediente'];
        $paciente->fecha_ingreso = $validated['fecha_ingreso'];
        $paciente->nombres = $validated['nombres'];
        $paciente->apellidos = $validated['apellidos'];
        $paciente->dui = $validated['dui'];
        $paciente->fecha_nacimiento = $validated['fecha_nacimiento'];
        $paciente->genero = $validated['genero'];
        $paciente->edad = $validated['edad'];
        $paciente->estado_civil = $validated['estado_civil'];
        $paciente->direccion = $validated['direccion'];
        $paciente->telefono = $validated['telefono'];
        $paciente->celular = $validated['celular'];
        $paciente->correo = $validated['correo'];
        $paciente->whatsapp = $validated['whatsapp'];
        $paciente->emergencia_contacto = $validated['emergencia_contacto'];
        $paciente->emergencia_telefono = $validated['emergencia_telefono'];
        $paciente->ha_visitado_odontologo = $validated['ha_visitado_odontologo'];
        $paciente->save();

        // Obtener el ID del paciente recién guardado
        $patientId = $paciente->id;

        // Guardar Evaluación Sistémica
        $evaluacionSistemica = new EvaluacionSistemica();
        $evaluacionSistemica->patient_id = $patientId;
        $evaluacionSistemica->historia_enfermedad = $validated['historia_enfermedad'];
        $evaluacionSistemica->historia_medica_personal = $validated['historia_medica_personal'];
        $evaluacionSistemica->antecedentes_medicos_familiares = $validated['antecedentes_medicos_familiares'];
        $evaluacionSistemica->save();

        // Guardar Signos Vitales
        $signosVitales = new SignosVitales();
        $signosVitales->patient_id = $patientId;
        $signosVitales->pa = $validated['pa'];
        $signosVitales->pulso = $validated['pulso'];
        $signosVitales->temperatura = $validated['temperatura'];
        $signosVitales->save();

        // Guardar Exámenes Clínicos
        $examenClinico = new ExamenesClinicos();
        $examenClinico->patient_id = $patientId;
        $examenClinico->examen_extraoral = $validated['examen_extraoral'];
        $examenClinico->examen_intraoral = $validated['examen_intraoral'];
        $examenClinico->save();

        // Guardar Evaluación Regional
        $evaluacionRegional = new EvaluacionRegional();
        $evaluacionRegional->patient_id = $patientId;
        $evaluacionRegional->region = $validated['region'];
        $evaluacionRegional->condicion = $validated['condicion'];
        $evaluacionRegional->observacion = $validated['observacion'];
        $evaluacionRegional->save();

        // Guardar Enfermedades Comunes
        $enfermedadesComunes = new EnfermedadesComunes();
        $enfermedadesComunes->patient_id = $patientId;
        $enfermedadesComunes->hipertension = $validated['hipertension'];
        $enfermedadesComunes->diabetes = $validated['diabetes'];
        $enfermedadesComunes->hemofilia = $validated['hemofilia'];
        $enfermedadesComunes->tumor_labio = $validated['tumor_labio'];
        $enfermedadesComunes->medicamento = $validated['medicamento'];
        $enfermedadesComunes->tumor_cervico = $validated['tumor_cervico'];
        $enfermedadesComunes->sindrome_down = $validated['sindrome_down'];
        $enfermedadesComunes->tumor_mama = $validated['tumor_mama'];
        $enfermedadesComunes->tumor_pulmon = $validated['tumor_pulmon'];
        $enfermedadesComunes->autismo = $validated['autismo'];
        $enfermedadesComunes->tumor_colon = $validated['tumor_colon'];
        $enfermedadesComunes->tumor_estomago = $validated['tumor_estomago'];
        $enfermedadesComunes->paralisis = $validated['paralisis'];
        $enfermedadesComunes->erc = $validated['erc'];
        $enfermedadesComunes->cardiopatia = $validated['cardiopatia'];
        $enfermedadesComunes->endocarditis = $validated['endocarditis'];
        $enfermedadesComunes->otros = $validated['otros'];
        $enfermedadesComunes->save();

        DB::commit();

        return redirect()->route('admin.patient.index')->with('success', 'Paciente creado exitosamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al guardar el paciente: ' . $e->getMessage());
        return redirect()->back()->withErrors('Error al guardar el paciente. Por favor, inténtalo de nuevo.');
    }
}



    // Método para generar el PDF de pacientes
    public function generarPDFPacientes()
    {
        // Obtiene todos los pacientes
        $pacientes = Patient::all();
    
        // Cargar la vista y pasarle los pacientes
        $pdfView = view('admin.pacientes.reporte_pacientes', compact('pacientes'))->render();
    
        // Inicializar Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
    
        // Cargar el contenido HTML
        $dompdf->loadHtml($pdfView);
    
        // Configurar tamaño y orientación
        $dompdf->setPaper('A4', 'landscape'); // Cambia 'landscape' a 'portrait' si prefieres vertical
    
        // Renderizar el PDF
        $dompdf->render();
    
        // Salida del PDF
        return $dompdf->stream('reporte_pacientes.pdf', ['Attachment' => true]);
    }
    



    // Gestionar usuarios
    public function manageUsers()
    {
        $users = User::all();
        return view('admin.usuarios.manage-users', compact('users'));
    }

    // Actualizar usuario
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
        ]);

        $user->roles()->sync(Role::where('name', $validatedData['role'])->first());

        return redirect()->route('admin.manageUsers')->with('success', 'Datos actualizados exitosamente.');
    }


    public function indexOOdontograma()
    {
        // Aquí cargas los datos necesarios para la vista
        return view('admin.odontograma.index'); // Asegúrate de que la vista odontograma/index.blade.php exista
    }

    public function indexOdontograma()
    {
        return view('admin.odontograma.index');
    }

    public function createOdontograma()
    {
        return view('admin.odontograma.create');
    }

    public function storeOdontograma(Request $request)
    {
        // Lógica para guardar el odontograma
    }

    public function editOdontograma($id)
    {
        // Lógica para mostrar la vista de edición
    }

    public function updateOdontograma(Request $request, $id)
    {
        // Lógica para actualizar el odontograma
    }

    public function destroyOdontograma($id)
    {
        // Lógica para eliminar el odontograma
    }




    // ODONTOGRAMA GUARDADO PRUEBA


    // Método para obtener la lista de médicos
    public function getDoctors(Request $request)
    {
        $doctors = Medico::select('id', 'name')->get();
        return response()->json($doctors);
    }

   

    public function consultaCreate($id)
{
    // Obtener al paciente por ID
    $patient = Patient::findOrFail($id);

    // Obtener la última consulta del paciente, ordenada por created_at de manera descendente
    $ultimaConsulta = Consulta::where('patient_id', $id)
                              ->orderBy('created_at', 'desc')
                              ->first();

    // Si existe una consulta, formatear la fecha
    $ultimaConsultaFecha = $ultimaConsulta ? Carbon::parse($ultimaConsulta->created_at)->locale('es')->isoFormat('dddd D MMMM [de] YYYY') : 'Aun no cuenta con ninguna consulta';

    // Obtener todos los tratamientos dentales
    $tratamientos_dentales = TratamientoDental::all();

    // Pasar los datos a la vista
    return view('admin.patient.consulta-create', compact('patient', 'ultimaConsultaFecha', 'tratamientos_dentales'));
}
    

public function consultaStore(Request $request, $id)
{
    // Validar los datos del formulario, incluyendo los nuevos campos
    $request->validate([
        'plan_atencion' => 'nullable|string',
        'motivo_consulta' => 'required|string',
        'diagnostico' => 'nullable|string',
        'tratamiento_propuesto' => 'nullable|string',
        'observaciones' => 'nullable|string',
        'presion_arterial' => 'nullable|string|regex:/^\d+\/\d+$/',
        'pulso' => 'nullable|string|regex:/^\d+ bpm$/',
        'temperatura' => 'nullable|string|regex:/^\d+(\.\d+)?°C$/',
        'tratamiento_dental_id' => 'nullable|integer|exists:tratamientos_dentales,id',
    ]);

    // Crear una nueva instancia de Consulta y asignar los valores
    $consulta = new Consulta();
    $consulta->patient_id = $id;
    $consulta->plan_atencion = $request->input('plan_atencion');
    $consulta->motivo_consulta = $request->input('motivo_consulta');
    $consulta->diagnostico = $request->input('diagnostico');
    $consulta->tratamiento_propuesto = $request->input('tratamiento_propuesto');
    $consulta->observaciones = $request->input('observaciones');
    $consulta->presion_arterial = $request->input('presion_arterial');
    $consulta->pulso = $request->input('pulso');
    $consulta->temperatura = $request->input('temperatura');
    $consulta->tratamiento_dental_id = $request->input('tratamiento_dental_id');

    $consulta->save();

    return redirect()->route('admin.patient.index')->with('success', 'Consulta guardada exitosamente');
}





}



