<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Patient;
use App\Models\ConsentimientoInformado;
use Illuminate\Http\Request;
use PDF;

class ConsentimientoController extends Controller
{
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

    // Cambia esta línea
    return redirect()->route('admin.consentimientos.pdf', $consentimiento->id);
}

public function generatePDF($id)
{
    $consentimiento = ConsentimientoInformado::with('medico', 'patient')->findOrFail($id);

    // Obtener el nombre del paciente
    $patientName = $consentimiento->patient->nombres . ' ' . $consentimiento->patient->apellidos;

    // Generar el PDF
    $pdf = PDF::loadView('admin.consentimientos.pdf', compact('consentimiento'));

    // Usar el nombre del paciente en el nombre del archivo
    return $pdf->download('consentimiento_informado_' . $patientName . '.pdf');
}
}
