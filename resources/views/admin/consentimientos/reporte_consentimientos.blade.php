<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Consentimientos Informados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="title">
        <h1>Reporte de Consentimientos Informados</h1>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Médico</th>
                <th>Paciente</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consentimientos as $consentimiento)
                <tr>
                    <td>{{ $consentimiento->id }}</td>
                    <td>{{ $consentimiento->medico->nombre }}</td>
                    <td>{{ $consentimiento->patient->nombres . ' ' . $consentimiento->patient->apellidos }}</td>
                    <td>{{ $consentimiento->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
