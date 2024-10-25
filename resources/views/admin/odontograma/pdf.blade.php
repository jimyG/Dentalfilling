<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odontogramas</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
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
<h1 style="text-align: center;">Lista de pacientes con Odontogramas</h1>

<div class="header-info">
    <p>Fecha: {{ date('d/m/Y') }}</p>
    <p>Hora: {{ date('H:i') }}</p>
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
