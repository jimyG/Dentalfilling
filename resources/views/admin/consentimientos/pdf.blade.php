<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consentimiento Informado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
        }
        .content {
            margin: 20px 0;
        }
        .signature {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
    <img src="" class="logo" alt="Logo">

        <h1>Consentimiento Informado</h1>
    </div>

    <div class="content">
        <p><strong>Médico:</strong> {{ $consentimiento->medico->name }}</p>
        <p><strong>Paciente:</strong> {{ $consentimiento->patient->nombres }} {{ $consentimiento->patient->apellidos }}</p>
        <p><strong>Contenido:</strong></p>
        <p>{{ $consentimiento->contenido }}</p>
    </div>

    <div class="signature">
        <p>Firma del Paciente: __________________________</p>
        <p>Firma del Médico: __________________________</p>
    </div>
</body>
</html>
