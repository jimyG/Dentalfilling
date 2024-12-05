@extends('layouts.menu')

@section('content')

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
</head>

<div class="container  padding: 20px; border-radius: 10px; height: calc(100vh - 40px); margin: 20px 0;">
    <div class="table-title">
        <h1>Consentimientos Informados</h1>
    </div>
    
    <div class="header-form d-flex justify-content-between mb-3">
        <!-- Botón Nueva Consentimiento alineado a la izquierda -->
        <a href="{{ route('admin.consentimientos.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Nuevo Consentimiento
        </a>

        <!-- Botón Imprimir alineado a la derecha -->
        <a href="{{ route('admin.consentimientos.reporte') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-printer"></i> Imprimir
        </a>
    </div>

    <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);">
        <thead class="table-info">
            <tr>
                <th class="text-center d-none d-md-table-cell">ID</th> <!-- Ocultar en pantallas pequeñas -->
                <th class="text-center">Nombre</th>
                <th class="text-center d-none d-md-table-cell">Fecha de Creación</th> <!-- Ocultar en pantallas pequeñas -->
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consentimientos as $consentimiento)
                <tr>
                    <td class="text-center d-none d-md-table-cell">{{ $consentimiento->id }}</td> <!-- Ocultar en pantallas pequeñas -->
                    <td class="text-center">
                        <i class="bi bi-person-fill me-2 icon-persona"></i> <!-- Icono de persona -->
                        {{ $consentimiento->patient->nombres . ' ' . $consentimiento->patient->apellidos }}
                    </td>
                    <td class="text-center d-none d-md-table-cell">
                        <i class="bi bi-calendar-fill me-2 icon-calendario"></i> <!-- Icono de calendario -->
                        {{ $consentimiento->created_at->translatedFormat('j \\de F \\de Y') }}
                    </td>

                    <td class="text-center">
                        <a href="{{ route('admin.consentimientos.pdf', $consentimiento->id) }}" class="btn btn-secondary btn-sm me-2">
                            <i class="bi bi-file-earmark-pdf"></i> Ver PDF
                        </a>

                         <!-- Verifica si el usuario tiene permiso para eliminar -->
                            <form id="delete-form-{{ $consentimiento->id }}" action="{{ route('admin.consentimientos.destroy', $consentimiento->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $consentimiento->id }})">
                                    <i class="bi bi-trash-fill"></i> Eliminar
                                </button>
                            </form>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagisación -->
    <div class="d-flex justify-content-center">
    {{ $consentimientos->links('vendor.pagination.custom') }}
    </div>


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
