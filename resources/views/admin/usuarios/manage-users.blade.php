@extends('layouts.menu')

@section('content')
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
            <a href="{{ route('users.report') }}" class="btn btn-secondary">
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

    <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <thead class="table-info">
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Email</th>
                <th class="text-center">Rol</th>
                <th class="text-center">Acciones</th>
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
                    <td>
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

@endsection
