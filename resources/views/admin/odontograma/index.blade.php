@extends('layouts.menu')

@section('content')

<!-- Overlay de carga, visible cuando showLoaderAndPrint está activo -->
<div id="loader-overlay" class="loader-overlay" style="display: none;">
    <div class="loader"></div>
</div>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>

<div class="container">
    <div class="table-title">
        <h1>Odontograma</h1>
    </div>

    <!-- Overlay de carga, visible cuando showLoaderAndPrint está activo 
    <div class="search-container d-flex justify-content-center mb-4">
        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar paciente">
        <button type="button" class="btn btn-outline-secondary" id="searchButton">
            <i class="bi bi-search"></i>
        </button>
    </div>-->

    <div class="header-form d-flex justify-content-between mb-3">
        <a href="{{ route('admin.odontograma.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Nuevo Odontograma
        </a>
        <a href="{{ route('odontograma.imprimir') }}" class="btn btn-secondary mb-3" onclick="showLoaderAndPrint(event)">
            <i class="bi bi-printer"></i> Imprimir
        </a>
    </div>

    <div class="">
        <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);">
            <thead class="table-info">
                <tr>
                    <th class="text-center d-none d-md-table-cell">ID</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center d-none d-md-table-cell">Teléfono</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="odontogramaTableBody">
                @foreach($odontogramas as $odontograma)
                    <tr>
                        <td class="text-center d-none d-md-table-cell">{{ $odontograma->id }}</td>
                        <td class="text-center">
                            <i class="bi bi-person-fill me-2 icon-persona"></i> <!-- Icono de persona -->
                            {{ $odontograma->patient->nombres }} {{ $odontograma->patient->apellidos }}
                        </td>
                        <td class="text-center d-none d-md-table-cell">
                            <i class="bi bi-telephone-fill me-2 icon-telefono"></i> <!-- Icono de teléfono -->
                            {{ $odontograma->patient->telefono }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('odontograma.show', ['id' => $odontograma->id]) }}" class="btn btn-info btn-sm me-2">
                                <i class="bi bi-eye-fill"></i> Mostrar
                            </a>
                            <form id="delete-form-{{ $odontograma->paciente_id }}" action="{{ route('odontograma.destroy', ['id' => $odontograma->paciente_id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $odontograma->paciente_id }})">
                                    <i class="bi bi-trash-fill"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Función de confirmación de eliminación
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Mostrar mensaje de éxito
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    
</script>

<script>
    function showLoaderAndPrint(event) {
    event.preventDefault(); // Evita la redirección instantánea

    // Mostrar la animación de carga
    const loaderOverlay = document.getElementById('loader-overlay');
    loaderOverlay.style.display = 'flex';

    // Realizar la solicitud AJAX para obtener el PDF
    fetch(event.target.href, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/pdf',
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al generar el PDF');
        }
        return response.blob(); // Obtener el archivo PDF como blob
    })
    .then(blob => {
        // Crear un enlace para descargar el archivo PDF
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'odontogramas.pdf';
        document.body.appendChild(a);
        a.click();
        a.remove(); // Remover el enlace después de descargar

        // Ocultar la animación de carga
        loaderOverlay.style.display = 'none';

        // Liberar el objeto URL creado
        window.URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error('Error:', error);
        loaderOverlay.style.display = 'none'; // Ocultar la animación en caso de error
        alert('Hubo un problema al generar el PDF.');
    });
}

</script>

<script>
    // Funcionalidad de búsqueda
$('#search').on('keyup', function() {
    var search = $(this).val().trim();

    if (search === '') {
        // Si el campo de búsqueda está vacío, restauramos el contenido original
        location.reload(); // Esto puede ser una forma de refrescar la tabla original
        return;
    }

    $.ajax({
        url: "{{ route('odontograma.search') }}", // Cambiado aquí para usar 'odontograma.search'
        method: 'GET',
        data: { search: search },
        success: function(response) {
            $('#odontogramaTableBody').html(''); // Limpiamos la tabla de resultados

            if (response.length > 0) {
                response.forEach(odontograma => {
                    $('#odontogramaTableBody').append(`
                        <tr>
                            <td class="text-center d-none d-md-table-cell">${odontograma.id}</td>
                            <td class="text-center">${odontograma.patient.nombres} ${odontograma.patient.apellidos}</td>
                            <td class="text-center d-none d-md-table-cell">${odontograma.patient.telefono}</td>
                            <td class="text-center">
                                <a href="{{ route('odontograma.show', '') }}/${odontograma.id}" class="btn btn-info btn-sm me-2">
                                    <i class="bi bi-eye-fill"></i> Mostrar
                                </a>
                                <form id="delete-form-${odontograma.paciente_id}" action="{{ route('odontograma.destroy', '') }}/${odontograma.paciente_id}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${odontograma.paciente_id})">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `);
                });
            } else {
                $('#odontogramaTableBody').html('<tr><td colspan="4" class="text-center">No se encontraron registros</td></tr>');
            }
        },
        error: function() {
            $('#odontogramaTableBody').html('<tr><td colspan="4" class="text-center">Error en la búsqueda</td></tr>');
        }
    });
});

</script>

@endsection

