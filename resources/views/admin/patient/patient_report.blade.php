<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Pacientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center; /* Centra todo el contenido en el body */
        }
        img.logo {
            max-width: 150px; /* Ajusta el tamaño del logo */
            margin-bottom: 20px; /* Espaciado debajo del logo */
        }
        h1 {
            font-size: 24px; /* Cambia el tamaño del h1 */
            margin-bottom: 10px; /* Espacio debajo del h1 */
        }
        .report-info {
            margin-bottom: 20px; /* Espacio debajo de la información del reporte */
            font-size: 16px; /* Tamaño de fuente para la información del reporte */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php
// Utiliza el cache si es necesario
$logoPath = public_path('img/logo.png');

if (file_exists($logoPath)) {
    // Cargar la imagen y convertirla a Base64
    $logo = base64_encode(file_get_contents($logoPath));
    $logoSrc = 'data:image/png;base64,'.$logo;
} else {
    // Manejo de errores si la imagen no se encuentra
    $logoSrc = ''; // O una imagen por defecto
}
?>
<img src="{{ $logoSrc }}" width="300" height="70">

    <h1>Reporte de Pacientes</h1>
    
    <!-- Sección para mostrar la fecha y hora de generación del reporte -->
    <div class="report-info">
        Fecha: {{ date('d/m/Y') }} &nbsp; &nbsp; Hora: {{ date('H:i:s') }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Fecha de Nacimiento</th>
                <th>Género</th>
                <th>Estado Civil</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Emergencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $paciente)
                <tr>
                    <td>{{ $paciente->id }}</td>
                    <td>{{ $paciente->nombres }} {{ $paciente->apellidos }}</td>
                    <td>{{ $paciente->fecha_nacimiento }}</td>
                    <td>{{ $paciente->genero }}</td>
                    <td>{{ $paciente->estado_civil }}</td>
                    <td>{{ $paciente->telefono }}</td>
                    <td>{{ $paciente->correo }}</td>
                    <td>{{ $paciente->emergencia_contacto }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
