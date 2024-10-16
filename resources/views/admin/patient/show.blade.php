@extends('layouts.menu')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Detalles del Paciente</h1>

        <a href="{{ route('admin.patient.index') }}" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left-circle"></i> Volver a la lista de pacientes
        </a>

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h2>{{ $paciente->nombres }} {{ $paciente->apellidos }}</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>N° Folio:</strong> {{ $paciente->id }}</p>
                        <p><strong>Fecha de Nacimiento:</strong> {{ $paciente->fecha_nacimiento }}</p>
                        <p><strong>Edad:</strong> {{ $paciente->edad }}</p>
                        <p><strong>Género:</strong> {{ $paciente->genero }}</p>
                        <p><strong>Estado Civil:</strong> {{ $paciente->estado_civil }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Teléfono:</strong> {{ $paciente->telefono }}</p>
                        <p><strong>Celular:</strong> {{ $paciente->celular }}</p>
                        <p><strong>Correo:</strong> {{ $paciente->correo }}</p>
                        <p><strong>WhatsApp:</strong> {{ $paciente->whatsapp }}</p>
                        <p><strong>Contacto de Emergencia:</strong> {{ $paciente->emergencia_contacto }} - {{ $paciente->emergencia_telefono }}</p>
                    </div>
                </div>

                <hr class="my-4">

                <h4>Signos Vitales</h4>
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>PA:</strong> {{ $paciente->signosVitales->first()->pa ?? 'No registrado' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Pulso:</strong> {{ $paciente->signosVitales->first()->pulso ?? 'No registrado' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Temperatura:</strong> {{ $paciente->signosVitales->first()->temperatura ?? 'No registrado' }}</p>
                    </div>
                </div>

                <hr class="my-4">

                <h4>Exámenes Clínicos</h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Examen Extraoral:</strong> {{ $paciente->examenesClinicos->first()->examen_extraoral ?? 'No registrado' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Examen Intraoral:</strong> {{ $paciente->examenesClinicos->first()->examen_intraoral ?? 'No registrado' }}</p>
                    </div>
                </div>

                <hr class="my-4">

                <h4>Historia Médica</h4>
                @if($paciente->evaluacionSistemica->isNotEmpty())
                    <p><strong>Enfermedad:</strong> {{ $paciente->evaluacionSistemica->first()->historia_enfermedad }}</p>
                    <p><strong>Historia Personal:</strong> {{ $paciente->evaluacionSistemica->first()->historia_medica_personal }}</p>
                    <p><strong>Antecedentes Médicos Familiares:</strong> {{ $paciente->evaluacionSistemica->first()->antecedentes_medicos_familiares }}</p>
                @else
                    <p>No registrado</p>
                @endif

                <hr class="my-4">

                <h4>Evaluación Regional</h4>
                @if($paciente->evaluacionRegional->isNotEmpty())
                    @foreach($paciente->evaluacionRegional as $region)
                        <p><strong>{{ $region->region }}:</strong> {{ $region->condicion }} ({{ $region->observacion }})</p>
                    @endforeach
                @else
                    <p>No registrado</p>
                @endif
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.patient.edit', $paciente->id) }}" class="btn btn-warning mr-2">
                    <i class="bi bi-pencil-fill"></i> Editar
                </a>

                <form action="{{ route('admin.patient.destroy', $paciente->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    
                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $paciente->id }})">
                        <i class="bi bi-trash-fill"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>

        <a href="{{ route('admin.patient.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left-circle"></i> Volver a la lista de pacientes
        </a>
    </div>
    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: '¿Deseas eliminar este paciente?',
                text: "Esta acción no se puede deshacer",
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
