<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadesReportController extends Controller
{


    // Método para generar el PDF
    public function generarPDF()
    {
        $especialidades = Especialidad::all(); // Obtiene todas las especialidades

        // Cargar la vista para el PDF
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.especialidades.pdf', compact('especialidades'));

        return $pdf->stream('reporte_especialidades.pdf'); // Muestra el PDF en el navegador
    }
}
