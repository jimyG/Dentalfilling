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
    

    <a href="{{ route('admin.patient.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Nuevo Paciente
    </a>

    <!-- Hacer la tabla responsive -->
    <div class="table-responsive">
        <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);">
            <thead class="table-info">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Nombre Completo</th>
                    <th class="text-center">Fecha de Nacimiento</th>
                    <th class="text-center">Género</th>
                    <th class="text-center">Estado Civil</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Correo</th>
                    <th class="text-center">Emergencia</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="patientTableBody">
                @foreach ($pacientes as $paciente)
                    <tr>
                        <td class="text-center">{{ $paciente->id }}</td>
                        <td class="text-center">{{ $paciente->nombres }} {{ $paciente->apellidos }}</td>
                        <td class="text-center">{{ $paciente->fecha_nacimiento }}</td>
                        <td class="text-center">{{ $paciente->genero }}</td>
                        <td class="text-center">{{ $paciente->estado_civil }}</td>
                        <td class="text-center">{{ $paciente->telefono }}</td>
                        <td class="text-center">{{ $paciente->correo }}</td>
                        <td class="text-center">{{ $paciente->emergencia_contacto }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.patient.show', $paciente->id) }}" class="btn btn-info btn-sm me-2">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="{{ route('admin.patient.edit', $paciente->id) }}" class="btn btn-warning btn-sm me-2">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Agregar paginación si es necesario -->
    {{ $pacientes->links() }}
</div>

<script>
    $(document).ready(function() {
        // Configuración de AJAX para CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Funcionalidad de búsqueda
        $('#search').on('keyup', function() {
            var search = $(this).val();

            $.ajax({
                url: "{{ route('admin.patient.search') }}", // Asegúrate de que esta ruta esté bien
                method: 'GET',
                data: { search: search }, // Enviamos el término de búsqueda
                success: function(response) {
                    $('#patientTableBody').html(''); // Limpiamos la tabla de resultados

                    if (response.length > 0) {
                        response.forEach(paciente => {
                            $('#patientTableBody').append(`
                                <tr>
                                    <td class="text-center">${paciente.id}</td>
                                    <td class="text-center">${paciente.nombres} ${paciente.apellidos}</td>
                                    <td class="text-center">${paciente.fecha_nacimiento}</td>
                                    <td class="text-center">${paciente.genero}</td>
                                    <td class="text-center">${paciente.estado_civil}</td>
                                    <td class="text-center">${paciente.telefono}</td>
                                    <td class="text-center">${paciente.correo}</td>
                                    <td class="text-center">${paciente.emergencia_contacto}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.patient.show', '') }}/${paciente.id}" class="btn btn-info btn-sm me-2">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                        <a href="{{ route('admin.patient.edit', '') }}/${paciente.id}" class="btn btn-warning btn-sm me-2">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#patientTableBody').html('<tr><td colspan="9" class="text-center">Paciente no encontrado</td></tr>');
                    }
                }
            });
        });
    });
</script>
@endsection
