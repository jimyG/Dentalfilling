@extends('layouts.menu')

@section('content')
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>

<div class="container" style="padding: 20px; border-radius: 10px; height: calc(100vh - 40px); margin: 20px 0;">
    <div class="table-title">
        <h1>Odontograma</h1>
    </div>

    <div class="header-form d-flex justify-content-between mb-3">
        <a href="{{ route('admin.odontograma.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Nuevo Odontograma 
        </a>
        <a href="{{ route('odontograma.imprimir') }}" class="btn btn-secondary">
            <i class="bi bi-printer"></i> Imprimir
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);">
            <thead class="table-info">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Nombre Completo</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $seenPatients = []; // Array para seguir pacientes ya mostrados
                @endphp

                @foreach($odontogramas as $odontograma)
                    @if(!in_array($odontograma->paciente_id, $seenPatients))
                        <tr>
                            <td class="text-center">{{ $odontograma->id }}</td>
                            <td class="text-center">{{ $odontograma->patient->nombres }} {{ $odontograma->patient->apellidos }}</td>
                            <td class="text-center">{{ $odontograma->patient->telefono }}</td>
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
                        @php
                            $seenPatients[] = $odontograma->paciente_id; // Agregar paciente al array
                        @endphp
                    @endif
                @endforeach

            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>
@endsection
