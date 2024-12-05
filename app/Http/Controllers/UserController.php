<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Mostrar el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('admin.create-user'); // Asegúrate de que la vista sea correcta
    }

    /**
     * Almacenar un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->roles()->attach(Role::where('name', $validatedData['role'])->first());

        return redirect()->route('admin.usuarios.manage-users')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Mostrar el formulario para editar un usuario existente.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Obtenemos todos los roles para el select

        return view('admin.usuarios.edit-user', compact('user', 'roles'));
    }
    /**
     * Actualizar un usuario en la base de datos.
     */
    public function update(Request $request, $id)
    {
            try {
                $user = User::findOrFail($id);
                // Validaciones y actualización
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Error al actualizar el usuario: ' . $e->getMessage()]);
            }
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string'
        ]);
        // Actualizar los datos del usuario
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
        ]);
        // Actualizar el rol del usuario
        $user->roles()->sync(Role::where('name', $validatedData['role'])->first());

        return redirect()->route('admin.usuarios.manage-users')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
 * Eliminar un usuario de la base de datos.
 */
/**
 * Eliminar un usuario de la base de datos.
 */
public function destroy($id)
{
    try {
        $user = User::findOrFail($id);
        $user->delete(); // Eliminar el usuario

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.usuarios.manage-users')->with('success', 'Usuario eliminado exitosamente.');
    } catch (\Exception $e) {
        return redirect()->route('admin.usuarios.manage-users')->withErrors(['error' => 'Error al eliminar el usuario: ' . $e->getMessage()]);
    }
}



}
