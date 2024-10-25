<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class UserReportController extends Controller
{
    public function generateReport()
    {
        // Obtiene todos los usuarios
        $users = User::with('roles')->get();

        // Cargar la vista y pasarle los usuarios
        $pdfView = view('admin.usuarios.user_report', compact('users'))->render();

        // Inicializar Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Cargar el contenido HTML
        $dompdf->loadHtml($pdfView);

        // Configurar tamaño y orientación
        $dompdf->setPaper('A4', 'landscape');

        // Renderizar el PDF
        $dompdf->render();

        // Salida del PDF (cambiar a true para descargar)
        return $dompdf->stream('reporte_usuarios.pdf', ['Attachment' => true]);
    }
}
