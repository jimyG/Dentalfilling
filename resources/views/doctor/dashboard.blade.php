@extends('layouts.menu')

@section('content')

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

        <!-- Espacio entre los contadores y los gráficos -->
        <div class="mt-5">
            <div class="row">
                <!-- Gráfico de Pacientes -->
                <div class="col-md-6" >
                    <h4 class="mb-4 text-center poppins-semibold">Pacientes registrados</h4>
                    <label for="timeFilter">Filtrar por:</label>
                    <select id="filter" class="col-md-4" onchange="fetchPatientData()">
                        <option value="day">Hoy</option>
                        <option value="3days">Últimos 3 días</option>
                        <option value="week" selected>Última semana</option>
                        <option value="month">Último mes</option>
                        <option value="3months">Últimos 3 meses</option>
                        <option value="year">Último año</option>
                    </select>
                    <div class="chart-container patient-chart">
                        <canvas id="patientChart"></canvas>
                    </div>
                </div>

                <!-- Gráfico de Tratamientos Más Frecuentes -->
                <div class="col-md-6">
                    <h4 class="mb-4 text-center">Tratamientos Más Frecuentes</h4>
                    
                    <label for="timeFilter">Filtrar por:</label>
                    <select id="timeFilter" class="col-md-4" onchange="fetchFrequentTreatments()">
                        <option value="day">Hoy</option>
                        <option value="3days">Últimos 3 días</option>
                        <option value="week" selected>Última semana</option>
                        <option value="month">Último mes</option>
                        <option value="3months">Últimos 3 meses</option>
                        <option value="year">Último año</option>
                    </select>

                    <div class="chart-container treatment-chart">
                        <canvas id="treatmentChart"></canvas>
                    </div>
                </div>

                

            </div>
        </div>
    </div>
</div>

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



<script>
    let patientChart;

function fetchPatientData() {
    const filter = document.getElementById('filter').value;

    fetch(`/dashboard/recent-patients?filter=${filter}`)
        .then(response => response.json())
        .then(data => {
            const groupedData = {};

            data.forEach(item => {
                const date = item.date;
                const gender = item.genero;
                const count = item.total;

                if (!groupedData[date]) {
                    groupedData[date] = { masculino: 0, femenino: 0 };
                }
                groupedData[date][gender] = count;
            });

            const labels = Object.keys(groupedData);
            const maleCounts = labels.map(date => groupedData[date].masculino || 0);
            const femaleCounts = labels.map(date => groupedData[date].femenino || 0);

            if (patientChart) {
                patientChart.destroy();
            }

            const ctx = document.getElementById('patientChart').getContext('2d');
            patientChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Masculino',
                            data: maleCounts,
                            backgroundColor: 'rgba(221,242,225,255)', // Verde menta suave (con transparencia)
                            borderColor: '#1feabb',                     // Verde menta sólido
                            borderWidth: 1
                        },

                        {
                            label: 'Femenino',
                            data: femaleCounts,
                            backgroundColor: 'rgba(222,207,246,255)', // Morado lila suave
                            borderColor: '#C8A2C8',                      // Morado lila sólido
                            borderWidth: 1
                        }
                    ]

                },
                options: {
                    scales: {
                        x: {
                            title: { display: true, text: 'Fecha de ingreso' },
                            stacked: false,
                        },
                        y: {
                            title: { display: true, text: 'Número de pacientes' },
                            beginAtZero: true
                        }
                    },
                    barThickness: 30, // Ajusta el grosor de las barras
                    responsive: true,
        maintainAspectRatio: true, // Permite que el gráfico se ajuste a la ventana
        scales: { /* ... configuración de escalas ... */ }
                }
            });
        });
}

// Llamar a la función al cargar la página
fetchPatientData();

</script>


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
    let treatmentChart; // Definir la variable del gráfico fuera de la función

    function fetchFrequentTreatments() {
        const filter = document.getElementById('timeFilter').value; // Obtener el valor del filtro

        fetch(`/dashboard/frequent-treatments?filter=${filter}`)
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.nombre);
                const counts = data.map(item => item.total);
                const ctx = document.getElementById('treatmentChart').getContext('2d');

                // Si el gráfico ya existe, destrúyelo
                if (treatmentChart) {
                    treatmentChart.destroy();
                }

                // Verificar si hay datos
                if (labels.length === 0) {
                    // Crear un gráfico de pastel con el mensaje "Sin datos"
                    treatmentChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Sin datos'], // Etiqueta única para el gráfico
                            datasets: [{
                                data: [1], // Solo un punto de datos para que el gráfico se muestre
                                backgroundColor: ['rgba(200, 175, 240, 0.6)'], // Color para el gráfico
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                },
                                tooltip: {
                                    enabled: false // Deshabilitar tooltip
                                },
                                datalabels: {
                                    display: true,
                                    color: 'black',
                                    formatter: () => 'Sin datos' // Mostrar 'Sin datos' en el gráfico
                                }
                            }
                        }
                    });
                } else {
                    // Crear un gráfico normal si hay datos
                    treatmentChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: counts,
                                backgroundColor: [
                                    'rgba(200, 175, 240, 0.6)', // Morado Pastel
                                    'rgba(173, 216, 230, 0.6)', // Azul Pastel
                                    'rgba(255, 224, 189, 0.6)', // Durazno Pastel
                                    'rgba(198, 233, 205, 0.6)', // Verde Pastel
                                    'rgba(245, 187, 255, 0.6)', // Lavanda Pastel
                                ],
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                },
                            }
                        }
                    });
                }
            })
            .catch(error => console.error('Error fetching frequent treatments:', error));
    }

    // Llamar a la función cuando se carga la página
    document.addEventListener('DOMContentLoaded', fetchFrequentTreatments);
</script>




    

</body>

@endsection
