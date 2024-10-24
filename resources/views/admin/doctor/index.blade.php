@extends('layouts.menu')

@section('content')
    <div class="container">
    <div class="">
        <div class="table-title">
            <h1>Medicos</h1>
        </div>
        </div>
        <a href="{{ route('admin.doctor.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Nuevo Médico
        </a>

        <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <thead class="table-info">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Especialidad</th>
                    <th class="text-center">Sexo</th>
                    <th class="text-center">DUI</th>
                    <th class="text-center">Edad</th>
                    <th class="text-center">Número de Licencia</th>
                    <th class="text-center">Dirección</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicos as $medico)
                    <tr>
                        <td class="text-center">{{ $medico->id }}</td>
                        <td class="text-center">{{ $medico->name }}</td>
                        <td class="text-center">{{ $medico->email }}</td>
                        <td class="text-center">{{ $medico->especialidad->name }}</td>
                        <td class="text-center">{{ $medico->sexo->nombre }}</td>
                        <td class="text-center">{{ $medico->dui }}</td>
                        <td class="text-center">{{ $medico->edad }}</td>
                        <td class="text-center">{{ $medico->LicenseNumber }}</td>
                        <td class="text-center">{{ $medico->address }}</td>
                        <td class="text-center">{{ $medico->phone }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.doctor.edit', $medico->id) }}" class="btn btn-warning btn-sm me-2">
                                <i class="bi bi-pencil-fill"></i> Editar
                            </a>

                            <form action="{{ route('admin.doctor.destroy', $medico->id) }}" method="POST" style="display: inline-block;" id="delete-form-{{ $medico->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger " onclick="confirmDelete({{ $medico->id }})">
                                    <i class="bi bi-trash-fill"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Agregar paginación si es necesario -->
        {{ $medicos->links() }}
    </div>

    <!-- SweetAlert2 Script -->
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
                title: '¿Estás seguro de que deseas eliminar este médico?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar el formulario de eliminación
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
