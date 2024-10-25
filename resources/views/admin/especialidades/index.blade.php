@extends('layouts.menu')

@section('content')

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
            <a href="{{ route('admin.especialidades.especialidades.pdf') }}" class="btn btn-secondary">
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
                        <td class="text-center">{{ $especialidad->name }}</td>
                        <td class="text-center">{{ $especialidad->description }}</td>
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
@endsection

