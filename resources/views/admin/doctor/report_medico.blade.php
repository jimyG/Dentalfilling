<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Médicos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .report-info {
            margin-bottom: 20px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
        }
        /* Ajustar la tabla para que los textos largos se adapten */
        td, th {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        /* Estilo para el logo */
        img.logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php
    $logoPath = public_path('img/logo.png');
    if (file_exists($logoPath)) {
        $logo = base64_encode(file_get_contents($logoPath));
        $logoSrc = 'data:image/png;base64,' . $logo;
    } else {
        $logoSrc = ''; // Manejo de errores si la imagen no se encuentra
    }
    ?>
    <img src="{{ $logoSrc }}" class="logo" alt="Logo">

    <h1>Reporte de Médicos</h1>

    <div class="report-info">
        Fecha: {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }} &nbsp; &nbsp;
        Hora: {{ \Carbon\Carbon::now()->format('h:i:s A') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Especialidad</th>
                <th>Sexo</th>
                <th>DUI</th>
                <th>Edad</th>
                <th>Número de Licencia</th>
                <th>Dirección</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicos as $medico)
                <tr>
                    <td>{{ $medico->id }}</td>
                    <td>{{ $medico->name }}</td>
                    <td>{{ $medico->email }}</td>
                    <td>{{ $medico->especialidad->name }}</td>
                    <td>{{ $medico->sexo->nombre }}</td>
                    <td>{{ $medico->dui }}</td>
                    <td>{{ $medico->edad }}</td>
                    <td>{{ $medico->LicenseNumber }}</td>
                    <td>{{ $medico->address }}</td>
                    <td>{{ $medico->phone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
