<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadesController extends Controller
{
    public function index()
{
    // Recuperar las especialidades con paginación
    $especialidades = Especialidad::paginate(10); // Paginamos de 10 en 10

    return view('admin.especialidades.index', compact('especialidades'));
}


    public function create()
    {
        // Mostrar formulario para crear una nueva especialidad
        return view('admin.especialidades.create');
    }

    public function store(Request $request)
    {
        // Lógica para almacenar una nueva especialidad

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
        ]);

        // Guardar en la base de datos
        $especialidad = new Especialidad();
        $especialidad->name = $validatedData['name'];
        $especialidad->description = $validatedData['description'];
        $especialidad->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad creada con éxito');
    }

    public function edit($id)
{
    // Encontrar la especialidad por ID
    $especialidad = Especialidad::findOrFail($id);

    // Pasar la especialidad a la vista
    return view('admin.especialidades.edit', compact('especialidad'));
}


public function update(Request $request, $id)
{
    // Validar los datos
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
    ]);

    // Encontrar la especialidad por ID
    $especialidad = Especialidad::findOrFail($id);

    // Actualizar la especialidad
    $especialidad->update([
        'name' => $request->input('name'),
        'description' => $request->input('description'),
    ]);

    // Redirigir con mensaje de éxito
    return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad actualizada correctamente.');
}


    public function destroy($id)
    {
        // Eliminar la especialidad
        $especialidad = Especialidad::findOrFail($id);
        $especialidad->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad eliminada con éxito.');
        
    }
}
