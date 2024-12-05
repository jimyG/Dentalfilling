<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expediente del Paciente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h4 {
            margin-bottom: 10px;
            font-size: 14px;
            text-decoration: underline;
        }
        .table {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            padding: 5px;
            border: 1px solid #000;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ $paciente->nombres }} {{ $paciente->apellidos }}</h2>
            <p><strong>N° Folio:</strong> {{ $paciente->id }}</p>
        </div>

        <div class="section">
            <h4>Información Personal</h4>
            <p><strong>Fecha de Nacimiento:</strong> {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->translatedFormat('d \d\e F \d\e Y') }}</p>
            <p><strong>Edad:</strong> {{ $paciente->edad }}</p>
            <p><strong>Género:</strong> {{ $paciente->genero }}</p>
            <p><strong>Estado Civil:</strong> {{ $paciente->estado_civil }}</p>
            <p><strong>Teléfono:</strong> {{ $paciente->telefono }}</p>
            <p><strong>Celular:</strong> {{ $paciente->celular }}</p>
            <p><strong>Correo:</strong> {{ $paciente->correo }}</p>
            <p><strong>WhatsApp:</strong> {{ $paciente->whatsapp }}</p>
        </div>

        <div class="section">
            <h4>Signos Vitales</h4>
            <p><strong>PA:</strong> {{ $paciente->signosVitales->first()->pa ?? 'No registrado' }}</p>
            <p><strong>Pulso:</strong> {{ $paciente->signosVitales->first()->pulso ?? 'No registrado' }}</p>
            <p><strong>Temperatura:</strong> {{ $paciente->signosVitales->first()->temperatura ?? 'No registrado' }}</p>
        </div>

        <div class="section">
            <h4>Exámenes Clínicos</h4>
            <p><strong>Examen Extraoral:</strong> {{ $paciente->examenesClinicos->first()->examen_extraoral ?? 'No registrado' }}</p>
            <p><strong>Examen Intraoral:</strong> {{ $paciente->examenesClinicos->first()->examen_intraoral ?? 'No registrado' }}</p>
        </div>

        <div class="section">
            <h4>Historia Médica</h4>
            <p><strong>Enfermedad:</strong>{{ $paciente->evaluacionSistemica->first()->historia_enfermedad ?? 'No registrado' }}</p>
            <p><strong>Historia Personal:</strong>  {{ $paciente->evaluacionSistemica->first()->historia_medica_personal ?? 'No registrado' }}</p>
            <p><strong>Antecedentes Médicos Familiares:</strong> {{ $paciente->evaluacionSistemica->first()->antecedentes_medicos_familiares ?? 'No registrado' }}</p>
        </div>

        <div class="section">
            <h4>Enfermedades Comunes</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Enfermedad</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Hipertensión Arterial:</strong></td>
                        <td>{{ $paciente->enfermedadesComunes->hipertension ?? 'No registrado' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diabetes Mellitus:</strong></td>
                        <td>{{ $paciente->enfermedadesComunes->diabetes ?? 'No registrado' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Hemofilia:</strong></td>
                        <td>{{ $paciente->enfermedadesComunes->hemofilia ?? 'No registrado' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
