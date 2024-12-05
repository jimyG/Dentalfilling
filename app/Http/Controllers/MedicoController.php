<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Especialidad;
use App\Models\Sexo;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    // Mostrar todos los médicos
    public function index()
    {
        $medicos = Medico::paginate(10); // Paginación de 10 en 10
        return view('admin.doctor.index', compact('medicos'));
    }

    // Mostrar formulario para crear un nuevo médico
    public function create()
    {
       
        // Recuperar especialidades y sexos para el formulario
    $especialidades = Especialidad::all(); // Obtener todas las especialidades
    $sexos = Sexo::all(); // Obtener todas las opciones de sexo

    return view('admin.doctor.create', compact('especialidades', 'sexos'));
    }

    // Guardar un nuevo médico en la base de datos
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:medicos,email',
            'especialidad_id' => 'required|exists:especialidades,id',
            'sexo_id' => 'required|exists:sexos,id',
            'password' => 'required|min:8|confirmed',
            'dui' => 'required|string|max:10|unique:medicos,dui',
            'edad' => 'required|integer|min:18',
            'LicenseNumber' => 'required|digits:4|unique:medicos,LicenseNumber', // Validación de 4 dígitos
            'address' => 'required|string|max:255',
            'phone' => 'required|string|size:8', // Teléfono con exactamente 8 caracteres
        ]);

        // Guardar el nuevo médico en la base de datos
        $medico = new Medico();
        $medico->name = $validatedData['name'];
        $medico->email = $validatedData['email'];
        $medico->especialidad_id = $validatedData['especialidad_id'];
        $medico->sexo_id = $validatedData['sexo_id'];
        $medico->password = bcrypt($validatedData['password']); // Encriptar la contraseña
        $medico->dui = $validatedData['dui'];
        $medico->edad = $validatedData['edad'];
        $medico->LicenseNumber = $validatedData['LicenseNumber'];
        $medico->address = $validatedData['address'];
        $medico->phone = $validatedData['phone'];
        $medico->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.doctor.index')->with('success', 'Médico creado con éxito.');
    }

    // Mostrar formulario para editar un médico
    public function edit($id)
    {
        $medico = Medico::findOrFail($id);
        $especialidades = Especialidad::all();
        $sexos = Sexo::all();
        return view('admin.doctor.edit', compact('medico', 'especialidades', 'sexos'));
    }

    // Actualizar los datos de un médico existente
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:medicos,email,'.$id,
            'especialidad_id' => 'required|exists:especialidades,id',
            'sexo_id' => 'required|exists:sexos,id',
            'password' => 'nullable|min:8|confirmed', // La contraseña puede ser nula si no se actualiza
            'dui' => 'required|string|max:10|unique:medicos,dui,'.$id,
            'edad' => 'required|integer|min:18',
            'LicenseNumber' => 'required|digits:4|unique:medicos,LicenseNumber,'.$id,
            'address' => 'required|string|max:255',
            'phone' => 'required|string|size:8',
        ]);

        // Encontrar el médico por ID y actualizar
        $medico = Medico::findOrFail($id);
        $medico->name = $validatedData['name'];
        $medico->email = $validatedData['email'];
        $medico->especialidad_id = $validatedData['especialidad_id'];
        $medico->sexo_id = $validatedData['sexo_id'];
        if ($validatedData['password']) {
            $medico->password = bcrypt($validatedData['password']);
        }
        $medico->dui = $validatedData['dui'];
        $medico->edad = $validatedData['edad'];
        $medico->LicenseNumber = $validatedData['LicenseNumber'];
        $medico->address = $validatedData['address'];
        $medico->phone = $validatedData['phone'];
        $medico->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.doctor.index')->with('success', 'Médico actualizado con éxito.');
    }

    // Eliminar un médico de la base de datos
    public function destroy($id)
    {
        $medico = Medico::findOrFail($id);
        $medico->delete();

        return redirect()->route('admin.doctor.index')->with('success', 'Médico eliminado con éxito.');
    }

    public function printDoctors()
    {
        // Obtener los datos de los médicos
        $medicos = Medico::all();
    
        // Generar el PDF con la vista y los datos
        $pdf = PDF::loadView('admin.doctor.report_medico', compact('medicos'))
                  ->setPaper('a4', 'landscape'); // Establecer orientación horizontal (landscape)
    
        // Descargar el PDF
        return $pdf->download('reporte_medicos.pdf');
    }
}
