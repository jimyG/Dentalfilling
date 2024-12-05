@extends('layouts.menu')

@section('content')
<div class="container mt-5">

<div id="title-wrapper" class="d-flex align-items-start">
            <a href="{{ url('/admin/patient') }}" id="icon-link" class="me-3">
                <div id="custom-icon-container">
                    <i class="bi bi-house-fill"></i>
                </div>
            </a>
            <div class="table-title">
                <h1>Editar Paciente</h1>
            </div>
        </div>

    <a href="{{ route('admin.patient.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left-circle"></i> Volver a la lista de pacientes
    </a>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center">Editar Paciente: {{ $paciente->nombres }} {{ $paciente->apellidos }}</h2>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="card-header bg-primary text-white">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.patient.update', $paciente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Datos Personales -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombres">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" value="{{ old('nombres', $paciente->nombres) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos', $paciente->apellidos) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                               value="{{ old('fecha_nacimiento', \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="genero">Género</label>
                        <select class="form-control" id="genero" name="genero" required>
                            <option value="masculino" {{ $paciente->genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino" {{ $paciente->genero == 'femenino' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="estado_civil">Estado Civil</label>
                        <select class="form-control" id="estado_civil" name="estado_civil" required>
                            <option value="soltero" {{ $paciente->estado_civil == 'soltero' ? 'selected' : '' }}>Soltero</option>
                            <option value="casado" {{ $paciente->estado_civil == 'casado' ? 'selected' : '' }}>Casado</option>
                            <option value="viudo" {{ $paciente->estado_civil == 'viudo' ? 'selected' : '' }}>Viudo</option>
                            <option value="divorciado" {{ $paciente->estado_civil == 'divorciado' ? 'selected' : '' }}>Divorciado</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $paciente->telefono) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="celular">Celular</label>
                        <input type="text" class="form-control" id="celular" name="celular" value="{{ old('celular', $paciente->celular) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', $paciente->correo) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="whatsapp">WhatsApp</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $paciente->whatsapp) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="emergencia_contacto">Contacto de Emergencia</label>
                        <input type="text" class="form-control" id="emergencia_contacto" name="emergencia_contacto" value="{{ old('emergencia_contacto', $paciente->emergencia_contacto) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="emergencia_telefono">Teléfono de Emergencia</label>
                        <input type="text" class="form-control" id="emergencia_telefono" name="emergencia_telefono" value="{{ old('emergencia_telefono', $paciente->emergencia_telefono) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ha_visitado_odontologo">¿Ha Visitado al Odontólogo?</label>
                        <select class="form-control" id="ha_visitado_odontologo" name="ha_visitado_odontologo" required>
                            <option value="1" {{ $paciente->ha_visitado_odontologo ? 'selected' : '' }}>Sí</option>
                            <option value="0" {{ !$paciente->ha_visitado_odontologo ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>

                <!-- Resto del formulario -->
        <h4>Evaluación Sistémica del Paciente</h4>
        <div class="form-group">
            <label for="historia_enfermedad">Historia de Enfermedad</label>
            <input type="text" class="form-control" id="historia_enfermedad" name="historia_enfermedad" value="{{ old('historia_enfermedad', $paciente->evaluacionSistemica->first()->historia_enfermedad ?? '') }}">
        </div>

        <div class="form-group">
            <label for="historia_medica_personal">Historia Médica Personal</label>
            <input type="text" class="form-control" id="historia_medica_personal" name="historia_medica_personal" value="{{ old('historia_medica_personal', $paciente->evaluacionSistemica->first()->historia_medica_personal ?? '') }}">
        </div>

        <div class="form-group">
            <label for="antecedentes_medicos_familiares">Antecedentes Médicos Familiares</label>
            <input type="text" class="form-control" id="antecedentes_medicos_familiares" name="antecedentes_medicos_familiares" value="{{ old('antecedentes_medicos_familiares', $paciente->evaluacionSistemica->first()->antecedentes_medicos_familiares ?? '') }}">
        </div>
        <h4>Signos Vitales</h4>
        <div class="form-group">
            <label for="pa">Presión Arterial</label>
            <input type="text" class="form-control" id="pa" name="pa" value="{{ old('pa', $paciente->signosVitales->first()->pa ?? '') }}">
        </div>

        <div class="form-group">
            <label for="pulso">Pulso</label>
            <input type="text" class="form-control" id="pulso" name="pulso" value="{{ old('pulso', $paciente->signosVitales->first()->pulso ?? '') }}">
        </div>

        <div class="form-group">
            <label for="temperatura">Temperatura</label>
            <input type="text" class="form-control" id="temperatura" name="temperatura" value="{{ old('temperatura', $paciente->signosVitales->first()->temperatura ?? '') }}">
        </div>
        <h4>Exámenes Clínicos</h4>
        <div class="form-group mt-3">
            <label for="examen_extraoral">Examen Extraoral</label>
            <textarea class="form-control" id="examen_extraoral" name="examen_extraoral" rows="3">{{ $paciente->examenesClinicos->first()->examen_extraoral ?? '' }}</textarea>
        </div>

        <div class="form-group mt-3">
            <label for="examen_intraoral">Examen Intraoral</label>
            <textarea class="form-control" id="examen_intraoral" name="examen_intraoral" rows="3">{{ $paciente->examenesClinicos->first()->examen_intraoral ?? '' }}</textarea>
        </div>
        <!-- Formulario para editar regiones -->
        <h4>Evaluaciones Regionales</h4>
        <div id="regiones">
            @foreach($paciente->evaluacionRegional as $evaluacion)
            <div class="evaluacion-regional mt-3" id="region_{{ $loop->index }}">
                <div class="form-group">
                    <label for="region_{{ $loop->index }}">Región</label>
                    <select class="form-control" id="region_{{ $loop->index }}" name="regiones[{{ $loop->index }}][region]" required>
                        <option value="">Seleccione una región</option>
                        <option value="ganglios" {{ $evaluacion->region == 'ganglios' ? 'selected' : '' }}>Ganglios</option>
                        <option value="dientes" {{ $evaluacion->region == 'dientes' ? 'selected' : '' }}>Dientes</option>
                        <option value="lengua" {{ $evaluacion->region == 'lengua' ? 'selected' : '' }}>Lengua</option>
                        <option value="labios" {{ $evaluacion->region == 'labios' ? 'selected' : '' }}>Labios</option>
                        <option value="carrillos" {{ $evaluacion->region == 'carrillos' ? 'selected' : '' }}>Carrillos</option>
                        <option value="encias" {{ $evaluacion->region == 'encias' ? 'selected' : '' }}>Encías</option>
                        <option value="paladar" {{ $evaluacion->region == 'paladar' ? 'selected' : '' }}>Paladar</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="condicion_{{ $loop->index }}">Condición</label>
                    <select class="form-control" id="condicion_{{ $loop->index }}" name="regiones[{{ $loop->index }}][condicion]">
                        <option value="normal" {{ $evaluacion->condicion == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="anormal" {{ $evaluacion->condicion == 'anormal' ? 'selected' : '' }}>Anormal</option>
                        <option value="no_acepta_revision" {{ $evaluacion->condicion == 'no_acepta_revision' ? 'selected' : '' }}>No Acepta Revisión</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="observacion_{{ $loop->index }}">Observación</label>
                    <textarea class="form-control" id="observacion_{{ $loop->index }}" name="regiones[{{ $loop->index }}][observacion]" rows="3">{{ old('regiones[' . $loop->index . '][observacion]', $evaluacion->observacion) }}</textarea>
                </div>

                <!-- Botón para eliminar la región -->
                <div class="form-group">
                    <button type="button" class="btn btn-danger" onclick="eliminarRegion({{ $loop->index }})">Eliminar Región</button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-success" onclick="agregarRegion()">Agregar Región</button>
        </div>

        <button type="submit" class="btn btn-primary mr-2">Actualizar Paciente</button>
    </form>
</div>


<script>
    // Función para agregar una nueva región (puedes personalizar los campos si es necesario)
    function agregarRegion() {
        const regionsContainer = document.getElementById('regiones');
        const newIndex = regionsContainer.children.length;

        const newRegionHTML = `
            <div class="evaluacion-regional mt-3" id="region_${newIndex}">
                <div class="form-group">
                    <label for="region_${newIndex}">Región</label>
                    <select class="form-control" id="region_${newIndex}" name="regiones[${newIndex}][region]" required>
                        <option value="">Seleccione una región</option>
                        <option value="ganglios">Ganglios</option>
                        <option value="dientes">Dientes</option>
                        <option value="lengua">Lengua</option>
                        <option value="labios">Labios</option>
                        <option value="carrillos">Carrillos</option>
                        <option value="encias">Encías</option>
                        <option value="paladar">Paladar</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="condicion_${newIndex}">Condición</label>
                    <select class="form-control" id="condicion_${newIndex}" name="regiones[${newIndex}][condicion]">
                        <option value="normal">Normal</option>
                        <option value="anormal">Anormal</option>
                        <option value="no_acepta_revision">No Acepta Revisión</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="observacion_${newIndex}">Observación</label>
                    <textarea class="form-control" id="observacion_${newIndex}" name="regiones[${newIndex}][observacion]" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-danger" onclick="eliminarRegion(${newIndex})">Eliminar Región</button>
                </div>
            </div>
        `;

        regionsContainer.insertAdjacentHTML('beforeend', newRegionHTML);
    }

    // Función para eliminar una región
    function eliminarRegion(index) {
        const regionDiv = document.getElementById(`region_${index}`);
        regionDiv.remove();
    }
</script>

@endsection
