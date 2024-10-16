<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToothSurface; // Asegúrate de que este modelo existe.

class ToothSurfaceController extends Controller
{
    // Método para obtener las superficies del diente
    public function getToothSurfaces($id)
{
    // Verificar si el ID es válido
    if (!$id) {
        return response()->json(['error' => 'ID de diente inválido.'], 400);
    }

    // Obtener las superficies del diente desde la base de datos
    $surfaces = ToothSurface::where('tooth_id', $id)->first();

    if ($surfaces) {
        // Decodificar el JSON guardado en 'surfaces'
        $surfacesData = json_decode($surfaces->surfaces, true);

        return response()->json(['surfaces' => $surfacesData]);
    }

    return response()->json(['surfaces' => []]); // Retornar un arreglo vacío si no hay datos
}

    // Método para guardar las superficies
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'surfaces' => 'required|array',
            'surfaces.*' => 'array', // Cambiar a 'array' para permitir estructuras anidadas
        ]);

        // Guardar los datos en la base de datos
        foreach ($request->surfaces as $toothId => $surfaces) {
            // Aquí asumo que tienes un modelo que maneja las superficies de los dientes
            ToothSurface::updateOrCreate(
                ['tooth_id' => $toothId],
                ['surfaces' => json_encode($surfaces)] // Guardar como JSON
            );
        }

        return response()->json(['message' => 'Datos guardados correctamente.'], 200);
    }
}
