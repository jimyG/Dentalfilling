<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyudaController extends Controller
{
    public function index()
    {
        // Lógica para mostrar la vista del índice
        return view('admin.ayuda.index'); // Ajusta esto según tu estructura de carpetas
    }

    public function desarrolladores()
    {
        return view('admin.ayuda.desarrolladores'); // 
    }

    public function descargarPdf($tipo)
    {
        // Ruta del archivo PDF que deseas descargar
        $pathToFile = public_path("pdf/{$tipo}.pdf"); // Usar el tipo para seleccionar el PDF

        // Verificar si el archivo existe antes de intentar descargarlo
        if (file_exists($pathToFile)) {
            return response()->download($pathToFile);
        } else {
            return redirect()->back()->with('error', 'El archivo no existe.');
        }
    }
}
