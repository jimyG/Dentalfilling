@extends('layouts.menu')

@section('content')
<!-- Overlay de carga, visible cuando showLoaderAndPrint está activo -->
<div id="loader-overlay" class="loader-overlay" style="display: none;">
    <div class="loader"></div>
</div>

<div class="container">
        <div class="table-title">
            <h1>Gestion de Usuarios</h1>
        </div>
        <div class="header-form d-flex justify-content-between mb-3">
            <!-- Botón Nuevo Usuario alineado a la izquierda -->
            <a href="{{ url('/admin/create-user') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Usuario
            </a>

            <!-- Botón Imprimir alineado a la derecha -->
            <!-- Botón de impresión -->
            <a href="{{ route('users.report') }}" class="btn btn-secondary" onclick="showLoaderAndPrint(event)">
                <i class="bi bi-printer"></i> Imprimir
            </a>

            

        </div>

    @if (session('success'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <!-- Mostrar el mensaje de confirmación de eliminación -->
    @if (session('success'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);">
        <thead class="table-info">
            <tr>
                <th class="text-center d-none d-md-table-cell">ID</th> <!-- Ocultar en pantallas pequeñas -->
                <th class="text-center">Nombre</th>
                <th class="text-center d-none d-md-table-cell">Email</th> <!-- Ocultar en pantallas pequeñas -->
                <th class="text-center d-none d-md-table-cell">Rol</th> <!-- Ocultar en pantallas pequeñas -->
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="text-center d-none d-md-table-cell" data-label="ID">{{ $user->id }}</td> <!-- Ocultar en pantallas pequeñas -->
                    <td class="text-center" data-label="Nombre">
                        <i class="bi bi-person-fill me-2 icon-persona"></i> <!-- Icono de persona -->
                        {{ $user->name }}
                    </td>
                    <td class="text-center d-none d-md-table-cell" data-label="Email">
                        <i class="bi bi-envelope-fill me-2 icon-correo"></i> <!-- Icono de correo -->
                        {{ $user->email }}
                    </td> <!-- Ocultar en pantallas pequeñas -->
                    <td class="text-center d-none d-md-table-cell" data-label="Rol">
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
                    <td class="text-center" data-label="Acciones">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="bi bi-pencil"></i> Editar
                        </a>

                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


</div>
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif


<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Se eliminara el usuario por completo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
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
        a.download = 'reporte_usuarios.pdf';
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
