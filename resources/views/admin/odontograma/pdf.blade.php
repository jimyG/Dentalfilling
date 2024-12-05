<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes con odontograma</title>
    
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            text-align: center; /* Centra todo el contenido en el body */
        }
        img.logo {
            max-width: 200px; /* Ajusta el tamaño del logo */
            margin-bottom: 20px; /* Espaciado debajo del logo */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .header-info {
            text-align: center;
            margin-bottom: 20px;
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

<h1 style="text-align: center;">Lista de pacientes con Odontogramas</h1>

<!-- Sección para mostrar la fecha y hora de generación del reporte -->
<div class="report-info">
    Fecha: {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }} &nbsp; &nbsp;
    Hora: {{ \Carbon\Carbon::now()->format('h:i:s A') }}
</div>


<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>Teléfono</th>
        </tr>
    </thead>
    <tbody>
        @foreach($odontogramas as $odontograma)
            <tr>
                <td>{{ $odontograma->id }}</td>
                <td>{{ $odontograma->patient->nombres }} {{ $odontograma->patient->apellidos }}</td>
                <td>{{ $odontograma->patient->telefono }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
