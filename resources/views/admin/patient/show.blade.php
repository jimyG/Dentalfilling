@extends('layouts.menu')

@section('content')

</style>
    <div class="container mt-5">
        <div class="table-title">
        <h1>Expediente</h1>
        </div>
        <div class="row mb-3">
            <!-- Columna de texto alineada a la izquierda -->
            <div class="col-6 text-start">
                <a href="{{ route('admin.patient.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Volver a la lista de pacientes
                </a>
            </div>

           
        </div>


        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h2>{{ $paciente->nombres }} {{ $paciente->apellidos }}</h2>
            </div>
            <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><i class="bi bi-file-earmark-text color-icon"></i> <strong>N° Expediente:</strong> {{ $paciente->id }}</p>
                    <p><i class="bi bi-calendar-fill me-2 color-icon"></i> <strong>Fecha de Nacimiento:</strong> {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->translatedFormat('d \d\e F \d\e Y') }}</p>
                    <p><i class="bi bi-person color-icon"></i> <strong>Edad:</strong> {{ $paciente->edad }}</p>
                    <p><i class="bi bi-gender-ambiguous color-icon"></i> <strong>Género:</strong> {{ $paciente->genero }}</p>
                    <p><i class="bi bi-person-heart color-icon"></i> <strong>Estado Civil:</strong> {{ $paciente->estado_civil }}</p>
                </div>
                <div class="col-md-6">
                    <p><i class="bi bi-telephone-fill me-2 color-icon"></i> <strong>Teléfono:</strong> {{ $paciente->telefono }}</p>
                    <p><i class="bi bi-telephone-fill me-2 color-icon"></i> <strong>Celular:</strong> {{ $paciente->celular }}</p>
                    <p><i class="bi bi-envelope-fill me-2 color-icon"></i> <strong>Correo:</strong> {{ $paciente->correo }}</p>
                    <p><i class="bi bi-whatsapp color-icon"></i> <strong>WhatsApp:</strong> {{ $paciente->whatsapp }}</p>
                    <p><i class="bi bi-person-circle color-icon"></i> <strong>Contacto de Emergencia:</strong> {{ $paciente->emergencia_contacto }} - {{ $paciente->emergencia_telefono }}</p>
                </div>
            </div>



                <hr class="my-4">

                                <h4>Signos Vitales</h4>
                                <div class="row">
                    <div class="col-md-4">
                        <p>
                            <span class="icon-container"><i class="bi bi-heart-pulse color-icon"></i></span>
                            <strong>PA:</strong> {{ $paciente->signosVitales->first()->pa ?? 'No registrado' }}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p>
                            <span class="icon-container"><i class="bi bi-heart color-icon"></i></span>
                            <strong>Pulso:</strong> {{ $paciente->signosVitales->first()->pulso ?? 'No registrado' }}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p>
                            <span class="icon-container"><i class="bi bi-thermometer color-icon"></i></span>
                            <strong>Temperatura:</strong> {{ $paciente->signosVitales->first()->temperatura ?? 'No registrado' }}
                        </p>
                    </div>
                </div>


                <hr class="my-4">

                <h4>Exámenes Clínicos</h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><i class="bi bi-search color-icon"></i> <strong>Examen Extraoral:</strong> {{ $paciente->examenesClinicos->first()->examen_extraoral ?? 'No registrado' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><i class="bi bi-search color-icon"></i> <strong>Examen Intraoral:</strong> {{ $paciente->examenesClinicos->first()->examen_intraoral ?? 'No registrado' }}</p>
                    </div>
                </div>


                <hr class="my-4">

                <h4>Historia Médica</h4>
                @if($paciente->evaluacionSistemica->isNotEmpty())
                <p><i class="bi bi-heart color-icon"></i> <strong>Enfermedad:</strong>{{ $paciente->evaluacionSistemica->first()->historia_enfermedad }}</p>
                <p><i class="bi bi-file-earmark-text color-icon"></i> <strong>Historia Personal:</strong>  {{ $paciente->evaluacionSistemica->first()->historia_medica_personal }}</p>
                    <p><i class="bi bi-file-earmark-text color-icon"></i> <strong>Antecedentes Médicos Familiares:</strong> {{ $paciente->evaluacionSistemica->first()->antecedentes_medicos_familiares }}</p>
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

                <hr class="my-4">
                <h4>Odontograma</h4>

                    @if($tieneOdontograma)
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill color-icon"></i>
                            <strong> ¡Odontograma registrado!</strong>
                        </div>
                    @else
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-x-circle-fill color-icon"></i>
                            <strong>No posee odontograma aún</strong>
                        </div>
                    @endif

                    <hr class="my-4">

                <h4 class="mb-3">Enfermedades Comunes</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="">
                                <th>Enfermedad</th>
                                <th>Estado</th>
                                <th>Enfermedad</th>
                                <th>Estado</th>
                                <th>Enfermedad</th>
                                <th>Estado</th>
                                <th>Enfermedad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="bi bi-heart-pulse color-icon"></i> <strong>Hipertensión Arterial:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->hipertension ?? 'No registrado' }}</td>
                                <td><i class="bi bi-droplet color-icon"></i> <strong>Diabetes Mellitus:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->diabetes ?? 'No registrado' }}</td>
                                <td><i class="bi bi-activity color-icon"></i> <strong>Hemofilia:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->hemofilia ?? 'No registrado' }}</td>
                                <td><i class="bi bi-person-square color-icon"></i> <strong>Tumor en Labio, Boca, Faringe:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->tumor_labio ?? 'No registrado' }}</td>
                            </tr>
                            <tr>
                                <td colspan="8"><i class="bi bi-capsule color-icon"></i> <strong>Medicamento que toma:</strong> {{ $paciente->enfermedadesComunes->medicamento ?? 'No registrado' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-gender-female color-icon"></i> <strong>Tumor Cervico Uterino:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->tumor_cervico ?? 'No registrado' }}</td>
                                <td><i class="bi bi-person-check color-icon"></i> <strong>Síndrome de Down:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->sindrome_down ?? 'No registrado' }}</td>
                                <td><i class="bi bi-gender-female color-icon"></i> <strong>Tumor en Mama:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->tumor_mama ?? 'No registrado' }}</td>
                                <td><i class="bi bi-lungs color-icon"></i> <strong>Tumor en Pulmón:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->tumor_pulmon ?? 'No registrado' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-person-badge color-icon"></i> <strong>Autismo:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->autismo ?? 'No registrado' }}</td>
                                <td><i class="bi bi-file-earmark-medical color-icon"></i> <strong>Tumor en Colon y Recto:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->tumor_colon ?? 'No registrado' }}</td>
                                <td><i class="bi bi-thermometer-half color-icon"></i> <strong>Tumor en Estómago:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->tumor_estomago ?? 'No registrado' }}</td>
                                <td><i class="bi bi-person-gear color-icon"></i> <strong>Parálisis Cerebral:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->paralisis ?? 'No registrado' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-droplet-half color-icon"></i> <strong>Enfermedad Renal Crónica (ERC):</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->erc ?? 'No registrado' }}</td>
                                <td><i class="bi bi-heart-half color-icon"></i> <strong>Cardiopatía Isquémica:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->cardiopatia ?? 'No registrado' }}</td>
                                <td><i class="bi bi-heart color-icon"></i> <strong>Endocarditis Aguda y Subaguda:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->endocarditis ?? 'No registrado' }}</td>
                                <td><i class="bi bi-question-circle color-icon"></i> <strong>Otros:</strong></td>
                                <td>{{ $paciente->enfermedadesComunes->otros ?? 'No registrado' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4 class="text-center">Historial de consultas</h4>
                <div class="row">
                    @if ($paciente->consultas->isNotEmpty()) <!-- Verificar si tiene consultas -->
                        <div class="col-md-12">
                            @foreach ($paciente->consultas as $consulta) <!-- Iterar sobre las consultas -->
                                <div class="consulta-card mb-4 p-3 border rounded">
                                    <h5>
                                        Consulta: {{ $consulta->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                                        - <strong>Hora:</strong> {{ $consulta->created_at->locale('es')->isoFormat('hh:mm A') }}
                                    </h5>

                                    <div class="row">
                                        <!-- Columna 1: Motivo, Diagnóstico y Tratamiento Propuesto -->
                                        <div class="col-md-6">
                                            <p><i class="bi bi-pen color-icon-consulta"></i> <strong>Motivo de la Consulta:</strong> {{ $consulta->motivo_consulta ?? 'No registrado' }}.</p>
                                            <p><i class="bi bi-clipboard-heart color-icon-consulta"></i> <strong>Diagnóstico:</strong> {{ $consulta->diagnostico ?? 'No registrado' }}.</p>
                                            <p><i class="bi bi-tooth color-icon-consulta"></i> <strong>Tratamiento Dental Aplicado:</strong> {{ $consulta->tratamientosDentales->nombre ?? 'No registrado' }}.</p>
                                            <p><i class="bi bi-capsule color-icon-consulta"></i> <strong>Tratamiento Propuesto:</strong> {{ $consulta->tratamiento_propuesto ?? 'No registrado' }}.</p>
                                        </div>

                                        <!-- Columna 2: Observaciones, Presión Arterial, Pulso, Temperatura -->
                                        <div class="col-md-6">
                                            <p><i class="bi bi-file-earmark-text color-icon-consulta"></i> <strong>Observaciones:</strong> {{ $consulta->observaciones ?? 'No registrado' }}.</p>
                                            <p><i class="bi bi-heart color-icon-consulta"></i> <strong>Presión Arterial:</strong> {{ $consulta->presion_arterial ?? 'No registrada' }}.</p>
                                            <p><i class="bi bi-heart-pulse color-icon-consulta"></i> <strong>Pulso:</strong> {{ $consulta->pulso ?? 'No registrado' }}.</p>
                                            <p><i class="bi bi-thermometer color-icon-consulta"></i> <strong>Temperatura:</strong> {{ $consulta->temperatura ?? 'No registrada' }}.</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-md-12">
                            <p>No se ha registrado historial clínico para este paciente.</p>
                        </div>
                    @endif
                </div>


            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.patient.edit', $paciente->id) }}" class="btn btn-warning mr-2">
                    <i class="bi bi-pencil-fill"></i> Editar
                </a>

                <form action="{{ route('admin.patient.destroy', $paciente->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    
                    
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
