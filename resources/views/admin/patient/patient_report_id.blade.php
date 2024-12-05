<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte del Paciente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            margin-top: 0;
        }


        

        .personal-info h1 {
    margin-bottom: 10px;
    font-size: 1.8rem;
    color: #007bff;
}

.personal-info h3 {
    margin-bottom: 15px;
    font-size: 1.4rem;
    color: #333;
}

.personal-info-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    font-size: 0.9rem;
}

.personal-info-table th, .personal-info-table td {
    padding: 8px 10px;
    border: 1px solid #ddd;
}

.personal-info-table th {
    background-color: #f2f2f2;
    font-weight: bold;
    color: #555;
}

.color-icon {
    color: #007bff;
    margin-right: 5px;
}
    </style>
</head>
<body>

<div class="container">
<div class="personal-info">
    <h1>Reporte del Paciente: {{ $paciente->nombre }} {{ $paciente->apellido }}</h1>
    <div class="report-info">
        Fecha: {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }} &nbsp; &nbsp;
        Hora: {{ \Carbon\Carbon::now()->format('h:i:s A') }}
    </div>
    <h3 class="mb-3">Datos Personales</h3>
    <table class="table-bordered personal-info-table">
        <thead>
            <tr>
                <th>Campo</th>
                <th>Detalle</th>
                <th>Contacto</th>
                <th>Información Adicional</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="bi bi-file-earmark-text color-icon"></i> <strong>N° Expediente:</strong></td>
                <td>{{ $paciente->id }}</td>
                <td><i class="bi bi-telephone-fill me-2 color-icon"></i> <strong>Teléfono:</strong> {{ $paciente->telefono }}</td>
                <td><i class="bi bi-gender-ambiguous color-icon"></i> <strong>Género:</strong> {{ $paciente->genero }}</td>
            </tr>
            <tr>
                <td><i class="bi bi-calendar-fill me-2 color-icon"></i> <strong>Fecha de Nacimiento:</strong></td>
                <td>{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->translatedFormat('d \d\e F \d\e Y') }}</td>
                <td><i class="bi bi-telephone-fill me-2 color-icon"></i> <strong>Celular:</strong> {{ $paciente->celular }}</td>
                <td><i class="bi bi-person color-icon"></i> <strong>Edad:</strong> {{ $paciente->edad }}</td>
            </tr>
            <tr>
                <td><i class="bi bi-person-heart color-icon"></i> <strong>Estado Civil:</strong></td>
                <td>{{ $paciente->estado_civil }}</td>
                <td><i class="bi bi-envelope-fill me-2 color-icon"></i> <strong>Correo:</strong> {{ $paciente->correo }}</td>
                <td><i class="bi bi-whatsapp color-icon"></i> <strong>WhatsApp:</strong> {{ $paciente->whatsapp }}</td>
            </tr>
            <tr>
                <td colspan="2"><i class="bi bi-person-circle color-icon"></i> <strong>Contacto de Emergencia:</strong></td>
                <td colspan="2">{{ $paciente->emergencia_contacto }} - {{ $paciente->emergencia_telefono }}</td>
            </tr>
        </tbody>
    </table>
</div>




    

    <!-- Signos Vitales -->
<div class="section">
<h3 class="mb-3">Signos Vitales</h3>
    @if($paciente->signosVitales && $paciente->signosVitales->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Presión Arterial</th>
                    <th>Pulso</th>
                    <th>Temperatura</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paciente->signosVitales as $signo)
                    <tr>
                        <td>{{ $signo->pa }}</td>  <!-- Cambiado a 'pa' -->
                        <td>{{ $signo->pulso }}</td>
                        <td>{{ $signo->temperatura }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se han registrado signos vitales.</p>
    @endif
</div>


 <!-- Exámenes Clínicos --> 
<div class="section">
<h3 class="mb-3">Examenes Clinicos</h3>
    @if(!$noDatos && $paciente->examenesClinicos && $paciente->examenesClinicos->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Examen Extraoral</th>
                    <th>Examen Intraoral</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paciente->examenesClinicos as $examen)
                    <tr>
                        <td>{{ $examen->examen_extraoral }}</td>
                        <td>{{ $examen->examen_intraoral }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay datos del paciente.</p>
    @endif
</div>


    <!-- Evaluación Sistémica -->
    <div class="section">
    <h3 class="mb-3">Evaluacion Sistemica</h3>
        @if($paciente->evaluacionSistemica && $paciente->evaluacionSistemica->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paciente->evaluacionSistemica as $evaluacion)
                        <tr>
                            <td>{{ $evaluacion->fecha }}</td>
                            <td>{{ $evaluacion->resultado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay evaluaciones sistémicas registradas.</p>
        @endif
    </div>

    <!-- Evaluación Regional -->
    <div class="section">
    <h3 class="mb-3">Evaluacion Regional</h3>
        @if($paciente->evaluacionRegional && $paciente->evaluacionRegional->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paciente->evaluacionRegional as $evaluacion)
                        <tr>
                            <td>{{ $evaluacion->fecha }}</td>
                            <td>{{ $evaluacion->resultado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay evaluaciones regionales registradas.</p>
        @endif
    </div>

    <h3 class="mb-3">Enfermedades Comunes</h3>
<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 12px;">
    <thead>
        <tr style="background-color: #f8f9fa;">
            <th style="padding: 8px; text-align: center;">Enfermedad</th>
            <th style="padding: 8px; text-align: center;">Estado</th>
            <th style="padding: 8px; text-align: center;">Enfermedad</th>
            <th style="padding: 8px; text-align: center;">Estado</th>
            <th style="padding: 8px; text-align: center;">Enfermedad</th>
            <th style="padding: 8px; text-align: center;">Estado</th>
            <th style="padding: 8px; text-align: center;">Enfermedad</th>
            <th style="padding: 8px; text-align: center;">Estado</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding: 8px;"><strong>Hipertensión Arterial:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->hipertension ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Diabetes Mellitus:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->diabetes ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Hemofilia:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->hemofilia ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Tumor en Labio, Boca, Faringe:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->tumor_labio ?? 'No registrado' }}</td>
        </tr>
        <tr>
            <td colspan="8" style="padding: 8px;"><strong>Medicamento que toma:</strong> {{ $paciente->enfermedadesComunes->medicamento ?? 'No registrado' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px;"><strong>Tumor Cervico Uterino:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->tumor_cervico ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Síndrome de Down:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->sindrome_down ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Tumor en Mama:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->tumor_mama ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Tumor en Pulmón:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->tumor_pulmon ?? 'No registrado' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px;"><strong>Autismo:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->autismo ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Tumor en Colon y Recto:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->tumor_colon ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Tumor en Estómago:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->tumor_estomago ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Parálisis Cerebral:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->paralisis ?? 'No registrado' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px;"><strong>Enfermedad Renal Crónica (ERC):</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->erc ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Cardiopatía Isquémica:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->cardiopatia ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Endocarditis Aguda y Subaguda:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->endocarditis ?? 'No registrado' }}</td>
            <td style="padding: 8px;"><strong>Otros:</strong></td>
            <td style="padding: 8px; text-align: center;">{{ $paciente->enfermedadesComunes->otros ?? 'No registrado' }}</td>
        </tr>
    </tbody>
</table>


    

    <!-- Odontograma -->
    <div class="section">
        <h2>Odontograma</h2>
        @if($paciente->odontograma)
            <img src="{{ asset('storage/' . $paciente->odontograma->imagen) }}" alt="Odontograma del paciente" style="max-width: 100%; height: auto;">
        @else
            <p>No se ha registrado odontograma.</p>
        @endif
    </div>


    <h4 class="text-center mb-4">Historial de Consultas</h4>
<div class="row">
    @if ($paciente->consultas->isNotEmpty()) 
        <div class="col-md-12">
            @foreach ($paciente->consultas as $consulta)
                <div class="consulta-card mb-4 p-4 border rounded shadow-sm" style="background-color: #e0e0e0; border-left: 4px solid #007bff;">
                    <h5 class="text-primary">
                        <strong>Consulta:</strong> {{ $consulta->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                        - <strong>Hora:</strong> {{ $consulta->created_at->locale('es')->isoFormat('hh:mm A') }}
                    </h5>

                    <div class="row mt-3">
                        <!-- Columna 1: Motivo, Diagnóstico y Tratamiento Propuesto -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p><i class="bi bi-pen text-muted"></i> <strong>Motivo de la Consulta:</strong> {{ $consulta->motivo_consulta ?? 'No registrado' }}.</p>
                            </div>
                            <div class="mb-3">
                                <p><i class="bi bi-clipboard-heart text-muted"></i> <strong>Diagnóstico:</strong> {{ $consulta->diagnostico ?? 'No registrado' }}.</p>
                            </div>
                            <div class="mb-3">
                                <p><i class="bi bi-tooth text-muted"></i> <strong>Tratamiento Dental Aplicado:</strong> {{ $consulta->tratamientosDentales->nombre ?? 'No registrado' }}.</p>
                            </div>
                            <div class="mb-3">
                                <p><i class="bi bi-capsule text-muted"></i> <strong>Tratamiento Propuesto:</strong> {{ $consulta->tratamiento_propuesto ?? 'No registrado' }}.</p>
                            </div>
                        </div>

                        <!-- Columna 2: Observaciones, Presión Arterial, Pulso, Temperatura -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p><i class="bi bi-file-earmark-text text-muted"></i> <strong>Observaciones:</strong> {{ $consulta->observaciones ?? 'No registrado' }}.</p>
                            </div>
                            <div class="mb-3">
                                <p><i class="bi bi-heart text-muted"></i> <strong>Presión Arterial:</strong> {{ $consulta->presion_arterial ?? 'No registrada' }}.</p>
                            </div>
                            <div class="mb-3">
                                <p><i class="bi bi-heart-pulse text-muted"></i> <strong>Pulso:</strong> {{ $consulta->pulso ?? 'No registrado' }}.</p>
                            </div>
                            <div class="mb-3">
                                <p><i class="bi bi-thermometer text-muted"></i> <strong>Temperatura:</strong> {{ $consulta->temperatura ?? 'No registrada' }}.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="col-md-12">
            <p class="text-center">No se ha registrado historial clínico para este paciente.</p>
        </div>
    @endif
</div>



</div>


</body>
</html>
