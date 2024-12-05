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
    table-layout: fixed; /* Esto ayuda a que las celdas no se expandan más de lo necesario */
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    word-wrap: break-word; /* Permite que el contenido largo se ajuste dentro de la celda */
}

th {
    background-color: #f2f2f2;
}

td {
    max-width: 150px; /* Establece un límite para el ancho de la celda */
    overflow: hidden;  /* Esconde cualquier contenido que se desborde */
    text-overflow: ellipsis; /* Agrega puntos suspensivos si el contenido es más largo que el espacio */
}


    /* Estilo específico para la impresión */
    @media print {
        /* Ajuste de la tabla en formato horizontal (landscape) */
        .table-report {
            width: 100%;
            table-layout: fixed; /* Asegura que la tabla se ajuste bien */
        }

        /* Asegura que el contenido ocupe todo el espacio disponible en la página */
        body {
            margin: 0;
            padding: 0;
        }

        /* Ajusta los márgenes para imprimir en paisaje */
        .report-info, h1 {
            text-align: left; /* Alinea el texto a la izquierda para mayor claridad en la impresión */
        }

        /* Reduce el tamaño de las fuentes y ajusta las celdas para que quepan mejor */
        th, td {
            font-size: 10px;
            padding: 5px; /* Reduce el espacio de relleno en las celdas */
        }

        /* Asegura que la página se genere en formato horizontal */
        @page {
            size: A4 landscape; /* Asegura que el PDF se genere en formato horizontal */
            margin: 10mm; /* Reduce el margen de la página */
        }
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
    Fecha: {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }} &nbsp; &nbsp;
    Hora: {{ \Carbon\Carbon::now()->format('h:i:s A') }}
</div>


<table border="1">
    <thead>
        <tr>
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
                <td>{{ $paciente?->nombres }} {{ $paciente->apellidos }}</td>
                <td>{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</td>
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
