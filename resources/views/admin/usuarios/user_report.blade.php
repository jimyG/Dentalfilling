<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Usuarios</title>
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
        .role-admin {
            background-color: #007bff; /* Fondo azul para Administrador */
            color: white;
            padding: 5px;
            border-radius: 5px;
        }
        .role-medico {
            background-color: #28a745; /* Fondo verde para Médico */
            color: white;
            padding: 5px;
            border-radius: 5px;
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

    <h1>Reporte de Usuarios</h1>
    
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
                <th>Email</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                            @if ($role->name == 'Administrador')
                                <span class="role-admin">{{ $role->name }}</span>
                            @elseif ($role->name == 'Médico')
                                <span class="role-medico">{{ $role->name }}</span>
                            @else
                                <span>{{ $role->name }}</span>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
