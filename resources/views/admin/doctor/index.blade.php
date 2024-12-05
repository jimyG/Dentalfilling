@extends('layouts.menu')

@section('content')
    <div class="container">
    <div class="">
        <div class="table-title">
            <h1>Medicos</h1>
        </div>
        </div>
        <div class="header-form d-flex justify-content-between mb-3">
            <!-- Botón Nuevo Doctor alineado a la izquierda -->
            <a href="{{ route('admin.doctor.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus-circle"></i> Nuevo Médico
            </a>

            <!-- Botón Imprimir alineado a la derecha -->
            <button class="btn btn-secondary mb-3" onclick="window.open('{{ route('admin.doctor.print') }}', '_blank')">
                <i class="bi bi-printer"></i> Imprimir
            </button>


        </div>
        <div class="table-responsive">
        <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);">
    <thead class="table-info">
        <tr>
            <th class="d-none d-md-table-cell">ID</th>
            <th>Nombre</th>
            <th class="d-none d-md-table-cell">Email</th>
            <th class="d-none d-md-table-cell">Especialidad</th>
            <th class="d-none d-md-table-cell">Edad</th>
            <th class="d-none d-md-table-cell">Licencia</th>
            <th class="d-none d-md-table-cell">Dirección</th>
            <th class="d-none d-md-table-cell">Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="patientTableBody">
        @foreach ($medicos as $medico)
            <tr>
                <td class="d-none d-md-table-cell">{{ $medico->id }}</td>
                <td>
                    <i class="bi bi-person-fill me-2 icon-persona"></i> <!-- Icono de persona -->
                    {{ $medico->name }}
                </td>
                <td class="d-none d-md-table-cell">
                    <i class="bi bi-envelope-fill me-2 icon-correo"></i> <!-- Icono de correo -->
                    {{ $medico->email }}
                </td>
                <td class="d-none d-md-table-cell">
                    <i class="bi bi-file-medical icon-especialidad me-2"></i> <!-- Icono para especialidad -->
                    {{ $medico->especialidad->name }}
                </td>
                <td class="d-none d-md-table-cell">
                    <i class="bi bi-calendar icon-edad me-2"></i> <!-- Icono para edad -->
                    {{ $medico->edad }}
                </td>
                <td class="d-none d-md-table-cell">
                    <i class="bi bi-card-text icon-licencia me-2"></i> <!-- Icono para número de licencia -->
                    {{ $medico->LicenseNumber }}
                </td>
                <td class="d-none d-md-table-cell">
                    <i class="bi bi-geo-alt icon-direccion me-2"></i> <!-- Icono para dirección -->
                    {{ $medico->address }}
                </td>
                <td class="d-none d-md-table-cell">
                    <i class="bi bi-telephone-fill me-2 icon-telefono"></i> <!-- Icono de teléfono -->
                    {{ $medico->phone }}
                </td>
                <td class="text-center">
                    <a href="{{ route('admin.doctor.edit', $medico->id) }}" class="btn btn-warning mb-1">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>
                    <form action="{{ route('admin.doctor.destroy', $medico->id) }}" method="POST" style="display: inline-block;" id="delete-form-{{ $medico->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger mb-1" onclick="confirmDelete({{ $medico->id }})">
                            <i class="bi bi-trash-fill"></i> Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

        </div>



    <!-- Paginación -->
    <div class="d-flex justify-content-center">
    {{ $medicos->links('vendor.pagination.custom') }}
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
