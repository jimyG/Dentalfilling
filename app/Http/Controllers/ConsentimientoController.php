<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Patient;
use App\Models\ConsentimientoInformado;
use Illuminate\Http\Request;
use PDF;

class ConsentimientoController extends Controller
{
    // Método para mostrar la lista de consentimientos informados
    public function index()
    {
        // Obtener los consentimientos informados con paginación de 5 elementos por página
        $consentimientos = ConsentimientoInformado::with('medico', 'patient')->paginate(5);

        // Retornar la vista con los consentimientos paginados
        return view('admin.consentimientos.index', compact('consentimientos'));
    }

    public function create()
    {
        $medicos = Medico::all();
        $patients = Patient::all();
        return view('admin.consentimientos.create', compact('medicos', 'patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medico_id' => 'required|exists:medicos,id',
            'patient_id' => 'required|exists:patients,id',
            'contenido' => 'required',
        ]);

        $consentimiento = ConsentimientoInformado::create([
            'medico_id' => $request->medico_id,
            'patient_id' => $request->patient_id,
            'contenido' => $request->contenido,
        ]);

        // Redirecciona a la vista de generar PDF individual
        return redirect()->route('admin.consentimientos.pdf', $consentimiento->id);
    }

    public function destroy($id)
    {
        $consentimiento = ConsentimientoInformado::findOrFail($id);
        $consentimiento->delete();

        return redirect()->route('admin.consentimientos.index')->with('success', 'Consentimiento eliminado correctamente');
    }

    // Generar un PDF individual por consentimiento informado
    public function generatePDF($id)
    {
        $consentimiento = ConsentimientoInformado::with('medico', 'patient')->findOrFail($id);

        // Obtener el nombre del paciente
        $patientName = $consentimiento->patient->nombres . ' ' . $consentimiento->patient->apellidos;

        // Generar el PDF
        $pdf = PDF::loadView('admin.consentimientos.pdf', compact('consentimiento'));

        // Descargar el PDF con el nombre del paciente
        return $pdf->download('consentimiento_informado_' . $patientName . '.pdf');
    }

    // Nueva función para generar el reporte completo de consentimientos
    public function reporteConsentimientos()
    {
        // Obtener todos los consentimientos informados
        $consentimientos = ConsentimientoInformado::with('medico', 'patient')->get();

        // Generar el PDF usando la vista `reporte_consentimientos`
        $pdf = PDF::loadView('admin.consentimientos.reporte_consentimientos', compact('consentimientos'));

        // Descargar el PDF como "reporte_consentimientos.pdf"
        return $pdf->download('reporte_consentimientos.pdf');
    }
}
