@extends('layouts.menu')

@section('content')
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    </head>

    <div class="container" style="padding: 20px; border-radius: 10px; height: calc(100vh - 40px); margin: 20px 0;">
    <div class="table-title">
        <h1>Odontograma</h1>
    </div>

    <a href="{{ route('admin.odontograma.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Crear Odontograma Nuevo
    </a>

    <div class="table-responsive">
        <table class="table table-hover" style="border-radius: 0.5rem; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);">
            <thead class="table-info">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Área</th>
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
                            <td class="text-center">{{ $odontograma->patient->nombres }}</td>
                            <td class="text-center">{{ $odontograma->area }}</td>
                            <td class="text-center">
                                <a href="{{ route('odontograma.show', $odontograma->id) }}" class="btn btn-info btn-sm me-2">
                                    <i class="bi bi-eye-fill"></i> Mostrar
                                </a>
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
