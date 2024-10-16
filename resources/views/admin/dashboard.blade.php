@extends('layouts.menu')

@section('content')

<head>
    <!-- Otras etiquetas <link> o <script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<div id="app">
<div class="container mt-4">
    <div class="row">
        <!-- Contador de Doctores -->
        <div class="col-12 col-sm-6 col-md-4 text-center">
            <div class="counter-card d-flex justify-content-between align-items-center"> <!-- Usar flexbox para el espacio -->
                <div>
                    <div class="numbers" id="doctorCount">0</div> <!-- Inicialmente en 0 -->
                    <div class="cardName">Doctores</div>
                </div>
                <div class="iconBx">
                    <i class="bi bi-person-check icon-large"></i> <!-- Ícono de doctores -->
                </div>
            </div>
        </div>

        <!-- Contador de Pacientes -->
        <div class="col-12 col-sm-6 col-md-4 text-center">
            <div class="counter-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="numbers" id="patientCount">0</div>
                    <div class="cardName">Pacientes</div>
                </div>
                <div class="iconBx">
                    <i class="bi bi-person icon-large"></i> <!-- Ícono de pacientes -->
                </div>
            </div>
        </div>

        <!-- Contador de Especialidades -->
        <div class="col-12 col-sm-6 col-md-4 text-center">
            <div class="counter-card d-flex justify-content-between align-items-center">
                <div>
                    <div class="numbers" id="specialtyCount">0</div>
                    <div class="cardName">Especialidades</div>
                </div>
                <div class="iconBx">
                    <i class="bi bi-book icon-large"></i> <!-- Ícono de especialidades -->
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script>
    $(document).ready(function() {
        // Llamar al endpoint para obtener los conteos
        $.ajax({
            url: '/dashboard/counts', // Asegúrate de que esta ruta sea correcta
            method: 'GET',
            success: function(data) {
                // Actualizar los contadores en la vista
                $('#doctorCount').text(data.doctors);
                $('#patientCount').text(data.patients);
                $('#specialtyCount').text(data.specialties); // Asegúrate de que esto exista en tu API
            },
            error: function(xhr) {
                console.error('Error al obtener los conteos:', xhr);
            }
        });
    });
</script>
@endsection
