<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Especialidades</title>
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
<img src="{{ $logoSrc }}" class="logo" alt="Logo">

<h1>Reporte de Especialidades</h1>

<!-- Sección para mostrar la fecha y hora de generación del reporte -->
<div class="report-info">
    Fecha: {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }} &nbsp; &nbsp;
    Hora: {{ \Carbon\Carbon::now()->format('h:i:s A') }}
</div>


<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($especialidades as $especialidad)
            <tr>
                <td>{{ $especialidad->id }}</td>
                <td>{{ $especialidad->name }}</td>
                <td>{{ $especialidad->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
