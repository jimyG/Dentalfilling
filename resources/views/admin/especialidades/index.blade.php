@extends('layouts.menu')

@section('content')
<!-- Overlay de carga, visible cuando showLoaderAndPrint está activo -->
<div id="loader-overlay" class="loader-overlay" style="display: none;">
    <div class="loader"></div>
</div>

<head>

</head>
    <div class="container  padding: 20px; border-radius: 10px; height: calc(100vh - 40px); margin: 20px 0;">
        <div class="table-title">
            <h1>Especialidades</h1>
        </div>
        
        <div class="header-form d-flex justify-content-between mb-3">
            <!-- Botón Nueva Especialidad alineado a la izquierda -->
            <a href="{{ route('admin.especialidades.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus-circle"></i> Nueva Especialidad
            </a>

            <!-- Botón Imprimir alineado a la derecha -->
            <a href="{{ route('admin.especialidades.especialidades.pdf') }}" class="btn btn-secondary mb-3" onclick="showLoaderAndPrint(event)">
                <i class="bi bi-printer"></i> Imprimir
            </a>
        </div>

        

        <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);">
            <thead class="table-info">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($especialidades as $especialidad)
                    <tr>
                        <td class="text-center">{{ $especialidad->id }}</td>
                        <td class="text-center">
                            <i class="bi bi-person-fill me-2 icon-persona"></i> <!-- Icono de persona -->
                            {{ $especialidad->name }}
                        </td>
                        <td class="text-center">
                            <i class="bi bi-file-medical icon-especialidad me-2"></i> <!-- Icono para especialidad -->
                            {{ $especialidad->description }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.especialidades.edit', $especialidad->id) }}" class="btn btn-warning btn-sm me-2">
                                <i class="bi bi-pencil-fill"></i> Editar
                            </a>

                            <form id="delete-form-{{ $especialidad->id }}" action="{{ route('admin.especialidades.destroy', $especialidad->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $especialidad->id }})">
                                    <i class="bi bi-trash-fill"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $especialidades->links() }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

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
        a.download = 'reporte_especialidades.pdf';
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
@endsection