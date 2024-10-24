@extends('layouts.menu')

@section('content')

<head>
    <!-- Otras etiquetas <link> o <script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>

<body id="main-body">
    <div id="app">
        <!-- Banner -->
        <div class="container-banner">
            <div id="banner">
                <h2>Bienvenido a Dental Filling</h2>
                <p id="doctor-name">Dr {{ Auth::user()->name }}</p>
                <p id="current-time">
                    <i class="bi bi-clock"> Hora: </i> <span id="time-display"></span>
                    &nbsp; <!-- Espacio entre el ícono y la fecha -->
                    <i class="bi bi-calendar"></i> <span id="date-display"></span>
                </p> <!-- Párrafo para mostrar la fecha y hora -->
            </div>
        </div>

        <div class="container-dashboard mt-1">
            <div class="row">
                <!-- Contador de Doctores -->
                <div class="col-12 col-sm-6 col-md-4 text-center">
                    <div class="counter-card d-flex justify-content-between align-items-center" id="doctorCounter">
                        <div>
                            <div class="numbers" id="doctorCount">0</div>
                            <div class="cardName">Doctores</div>
                        </div>
                        <div class="iconBx" id="doctorIconBx">
                        <i class="bi bi-person-badge icon-large"></i> <!-- Ícono de doctores -->
                        </div>
                    </div>
                </div>

                <!-- Contador de Pacientes -->
                <div class="col-12 col-sm-6 col-md-4 text-center">
                    <div class="counter-card d-flex justify-content-between align-items-center" id="patientCounter">
                        <div>
                            <div class="numbers" id="patientCount">0</div>
                            <div class="cardName">Pacientes</div>
                        </div>
                        <div class="iconBx" id="patientIconBx">
                            <i class="bi bi-person icon-large"></i> <!-- Ícono de pacientes -->
                        </div>
                    </div>
                </div>

                <!-- Contador de Especialidades -->
                <div class="col-12 col-sm-6 col-md-4 text-center">
                    <div class="counter-card d-flex justify-content-between align-items-center" id="specialtyCounter">
                        <div>
                            <div class="numbers" id="specialtyCount">0</div>
                            <div class="cardName">Especialidades</div>
                        </div>
                        <div class="iconBx" id="specialtyIconBx">
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
    
    <script>
    function updateTime() {
        const now = new Date();
        
        // Formateo de la fecha: "DD de MMMM de YYYY"
        const optionsDate = { day: 'numeric', month: 'long', year: 'numeric' };
        const formattedDate = now.toLocaleDateString('es-ES', optionsDate);

        // Formateo de la hora: "hh:mm:ss AM/PM"
        const optionsTime = { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true };
        const formattedTime = now.toLocaleTimeString('es-ES', optionsTime).replace(' a. m.', ' AM').replace(' p. m.', ' PM');

        // Actualizar el contenido del párrafo
        document.getElementById('time-display').textContent = formattedTime;
        document.getElementById('date-display').textContent = formattedDate;
    }

    // Actualizar la hora cada segundo
    setInterval(updateTime, 1000);

    // Llamar a la función una vez para inicializarla
    updateTime();
</script>


</body>

@endsection
