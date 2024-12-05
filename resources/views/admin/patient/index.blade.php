@extends('layouts.menu')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500,
            position: 'center'
        });
    @endif
</script>

<!-- Meta tag para CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
        <div class="table-title">
            <h1>Pacientes</h1>
        </div>
    
    <!-- Formulario de búsqueda centrado -->
    
    <div class="search-container d-flex justify-content-center mb-4">
    <input type="text" name="search" id="search" class="form-control" placeholder="Buscar paciente">
    <button type="button" class="btn btn-outline-secondary" id="searchButton">
        <i class="bi bi-search"></i>
    </button>
</div>
        <div class="header-form d-flex justify-content-between mb-3">
            <!-- Botón Nueva Especialidad alineado a la izquierda -->
            <a href="{{ route('admin.patient.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus-circle"></i> Nuevo Paciente
            </a>

            <!-- Botón Imprimir alineado a la derecha -->
            <a href="{{ route('admin.patient.pdf', $pacientes->first()->id) }}" class="btn btn-secondary mb-3">
        <i class="bi bi-printer"></i> Imprimir
    </a>
        </div>

    <!-- Hacer la tabla responsive -->
    <div class="table-responsive">
    <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);">
        <thead class="table-info">
            <tr>
                <th class="text-center d-none d-md-table-cell">N° Expediente</th>
                <th class="text-center">Nombre Completo</th>
                <th class="text-center d-none d-md-table-cell">Fecha de Nacimiento</th>
                <th class="text-center d-none d-md-table-cell">Teléfono</th>
                <th class="text-center d-none d-md-table-cell">Correo</th>
                <th class="text-center">Consultas</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="patientTableBody">
            @foreach ($pacientes as $paciente)
                <tr>
                    <td class="text-center d-none d-md-table-cell">{{ $paciente->id }}</td>
                    <td class="text-start">
                        <i class="bi bi-person-fill me-2 icon-persona"></i> <!-- Icono de persona -->
                        {{ $paciente->nombres }} {{ $paciente->apellidos }}
                    </td>

                    <td class="text-start d-none d-md-table-cell">
                        <i class="bi bi-calendar-fill me-2 icon-calendario"></i> <!-- Icono de calendario -->
                        {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->translatedFormat('d \\d\\e F \\d\\e Y') }}
                    </td>

                    <td class="text-start d-none d-md-table-cell">
                        <i class="bi bi-telephone-fill me-2 icon-telefono"></i> <!-- Icono de teléfono -->
                        {{ $paciente->telefono }}
                    </td>

                    <td class="text-start d-none d-md-table-cell">
                        <i class="bi bi-envelope-fill me-2 icon-correo"></i> <!-- Icono de correo -->
                        {{ $paciente->correo }}
                    </td>


                    <td class="text-center">
                        <a href="{{ route('admin.patient.consulta-create', $paciente->id) }}" class="btn btn-success">
                            <i class="bi bi-heart-pulse-fill"></i> Nuevo
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.patient.show', $paciente->id) }}" class="btn btn-info mb-1">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('admin.patient.edit', $paciente->id) }}" class="btn btn-warning mb-1">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


    <!-- Pagisación -->
    <div class="d-flex justify-content-center">
    {{ $pacientes->links('vendor.pagination.custom') }}
    </div>
</div>

<script>
    $(document).ready(function() {
        // Configuración de AJAX para CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Guardamos el HTML original de la tabla para restaurarla
        const originalTableContent = $('#patientTableBody').html();

        // Funcionalidad de búsqueda
        $('#search').on('keyup', function() {
            var search = $(this).val().trim();

            if (search === '') {
                // Si el campo de búsqueda está vacío, restauramos el contenido original
                $('#patientTableBody').html(originalTableContent);
                return;
            }

            // Mostrar un mensaje de "Cargando..." o un spinner mientras se realiza la búsqueda
            $('#patientTableBody').html('<tr><td colspan="8" class="text-center">Cargando...</td></tr>');

            $.ajax({
                url: "{{ route('admin.patient.search') }}", // Asegúrate de que esta URL esté bien definida
                method: 'GET',
                data: { search: search },
                success: function(response) {
                    $('#patientTableBody').html(''); // Limpiamos la tabla de resultados

                    if (response.length > 0) {
                        response.forEach(paciente => {
                            const fechaNacimiento = new Date(paciente.fecha_nacimiento).toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' });

                            // Validamos si el paciente tiene odontograma
                            const odontogramaIcon = paciente.tiene_odontograma 
                                ? `<span class="icon-container-o icon-check-green">
                                        <i class="icon-check">&#10003;</i>
                                   </span>`
                                : `<span class="icon-container icon-check-red">
                                        <i class="icon-check">&#10005;</i>
                                   </span>`;

                            $('#patientTableBody').append(`
                                <tr>
                                    <td class="text-center d-none d-md-table-cell"">
                                        
                                        ${paciente.id}
                                    </td>
                                    <td class="text-center">
                                        <i class="bi bi-person-fill me-2 icon-persona"></i> <!-- Icono de persona -->
                                        ${paciente.nombres} ${paciente.apellidos}
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        <i class="bi bi-calendar-fill me-2 icon-calendario"></i> <!-- Icono de calendario -->
                                        ${fechaNacimiento}
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        <i class="bi bi-telephone-fill me-2 icon-telefono"></i> <!-- Icono de teléfono -->
                                        ${paciente.telefono}
                                    </td>
                                    <td class="text-center d-none d-md-table-cell">
                                        <i class="bi bi-envelope-fill me-2 icon-correo"></i> <!-- Icono de correo -->
                                        ${paciente.correo}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.patient.consulta-create', $paciente->id) }}" class="btn btn-success">
                                            <i class="bi bi-heart-pulse-fill"></i> Nuevo
                                        </a>
                                    </td>         
                                    <td class="text-center">
                                        <a href="{{ route('admin.patient.show', '') }}/${paciente.id}" class="btn btn-info mb-1">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                        <a href="{{ route('admin.patient.edit', '') }}/${paciente.id}" class="btn btn-warning mb-1">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#patientTableBody').html('<tr><td colspan="8" class="text-center">Paciente no encontrado</td></tr>');
                    }
                },
                error: function() {
                    $('#patientTableBody').html('<tr><td colspan="8" class="text-center">Ocurrió un error. Inténtalo nuevamente.</td></tr>');
                }
            });
        });
    });
</script>




@endsection