<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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
        return view('admin.create-user');
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

        return redirect()->route('admin.createUserForm')->with('success', 'Usuario creado exitosamente.');
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
        $medicos = Medico::with('especialidad')->paginate(10);

        // Retorna la vista con la lista de médicos
        return view('admin.doctor.index', compact('medicos'));
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
        'LicenseNumber' => 'required|numeric|digits:4', // Asegura que el número de licencia sea de 4 dígitos
        'address' => 'required|string|max:255',
        'phone' => 'required|string|size:8', // Asume que el teléfono tiene 8 dígitos
    ], [
        'dui.unique' => 'El DUI ingresado ya está en uso. Por favor, ingresa otro.',
        'LicenseNumber.unique' => 'El número de licencia ingresado ya está en uso. Por favor, ingresa otro.', // Mensaje personalizado
        'LicenseNumber.digits' => 'El número de licencia debe ser de 4 dígitos.',
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


    // Formulario para crear paciente

    // Función para listar los pacientes
    public function indexPaciente()
    {
        $pacientes = Patient::paginate(10);
        return view('admin.patient.index', compact('pacientes')); // Cambia esta vista según tu estructura
    }

    // Función para mostrar el formulario de creación de paciente
    public function createPaciente()
    {
        // Puedes pasarle datos necesarios a la vista si es necesario
        return view('admin.patient.create');
    }

    public function searchPaciente(Request $request)
{
    // Obtener el término de búsqueda
    $searchTerm = $request->input('search');
    
    // Buscar pacientes que coincidan con el término
    $pacientes = Patient::where('nombres', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('apellidos', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('correo', 'LIKE', "%{$searchTerm}%")
                        ->get();
    
    // Retornar los resultados como respuesta JSON
    return response()->json($pacientes);
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
    //dd($request->all());

    // Validación de los campos requeridos y opcionales
    $validated = $request->validate([
        'expediente' => 'nullable|string|max:255',
        'fecha_ingreso' => 'required|date',
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'fecha_nacimiento' => 'required|date',
        'genero' => 'required|string|in:masculino,femenino',
        'edad' => 'required|integer',
        'estado_civil' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:15',
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
    ]);

    DB::beginTransaction();

    try {
        // Guardar el paciente
        $paciente = new Patient();
        $paciente->expediente = $validated['expediente'];
        $paciente->fecha_ingreso = $validated['fecha_ingreso'];
        $paciente->nombres = $validated['nombres']; // Cambiar nombre a 'nombres'
        $paciente->apellidos = $validated['apellidos'];
        $paciente->fecha_nacimiento = $validated['fecha_nacimiento'];
        $paciente->genero = $validated['genero'];
        $paciente->edad = $validated['edad'];
        $paciente->estado_civil = $validated['estado_civil'];
        $paciente->telefono = $validated['telefono'];
        $paciente->celular = $validated['celular'];
        $paciente->correo = $validated['correo'];
        $paciente->whatsapp = $validated['whatsapp'];
        $paciente->emergencia_contacto = $validated['emergencia_contacto'];
        $paciente->emergencia_telefono = $validated['emergencia_telefono'];
        $paciente->ha_visitado_odontologo = $validated['ha_visitado_odontologo'];
        $paciente->save();

        // Guardar Evaluación Sistémica
        $evaluacionSistemica = new EvaluacionSistemica();
        $evaluacionSistemica->patient_id = $paciente->id; // Cambiar 'paciente_id' a 'patient_id' si es necesario
        $evaluacionSistemica->historia_enfermedad = $validated['historia_enfermedad'];
        $evaluacionSistemica->historia_medica_personal = $validated['historia_medica_personal'];
        $evaluacionSistemica->antecedentes_medicos_familiares = $validated['antecedentes_medicos_familiares'];
        $evaluacionSistemica->save();

        // Guardar Signos Vitales
        $signosVitales = new SignosVitales();
        $signosVitales->patient_id = $paciente->id;
        $signosVitales->pa = $validated['pa'];
        $signosVitales->pulso = $validated['pulso'];
        $signosVitales->temperatura = $validated['temperatura'];
        $signosVitales->save();

        // Guardar Exámenes Clínicos
        $examenClinico = new ExamenesClinicos();
        $examenClinico->patient_id = $paciente->id; // Cambia esto si tu modelo requiere 'patient_id'
        $examenClinico->examen_extraoral = $validated['examen_extraoral'];
        $examenClinico->examen_intraoral = $validated['examen_intraoral'];
        $examenClinico->save();

        // Guardar Evaluación Regional
        $evaluacionRegional = new EvaluacionRegional();
        $evaluacionRegional->patient_id = $paciente->id;
        $evaluacionRegional->region = $validated['region'];
        $evaluacionRegional->condicion = $validated['condicion'];
        $evaluacionRegional->observacion = $validated['observacion'];
        $evaluacionRegional->save();

        // Confirmar la transacción si todo sale bien
        DB::commit();

        // Redirigir a la ruta 'admin.patient.create' con un mensaje de éxito
        return redirect()->route('admin.patient.index')->with('success', 'Paciente y evaluaciones guardados correctamente.');
        

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Revertir la transacción si hay un error
        DB::rollback();

        // Retornar los errores de validación
        return redirect()->back()->withErrors($e->validator->errors())->withInput();

    } catch (Exception $e) {
        // Revertir la transacción si hay un error
        DB::rollback();

        // Log para depuración
        Log::error('Error al guardar paciente: ' . $e->getMessage());

        // Retornar un mensaje de error detallado
        return redirect()->back()->with('error', 'Error al guardar los datos. Detalles: ' . $e->getMessage());
    }
}



    // Gestionar usuarios
    public function manageUsers()
    {
        $users = User::all();
        return view('admin.manage-users', compact('users'));
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

    // Método para obtener la lista de pacientes
    public function getPatients(Request $request)
    {
        $patients = Patient::select('id', 'nombres', 'apellidos')->get();
        return response()->json($patients);
    }

    //contadores


}
