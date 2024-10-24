@extends('layouts.menu')

@section('content')
<div class="container">
    <h1>Crear Nuevo Paciente</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form-container">
    <form action="{{ route('admin.patient.store') }}" method="POST">
        @csrf

        <div class="progress bar">

        </div>

        <!-- Navegación por etapas -->
        <ul class="nav nav-tabs" id="patientFormTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="stage1-tab" data-bs-toggle="tab" href="#stage1" role="tab" aria-controls="stage1" aria-selected="true">Etapa 1</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="stage2-tab" data-bs-toggle="tab" href="#stage2" role="tab" aria-controls="stage2" aria-selected="false">Etapa 2</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="stage3-tab" data-bs-toggle="tab" href="#stage3" role="tab" aria-controls="stage3" aria-selected="false">Etapa 3</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="stage4-tab" data-bs-toggle="tab" href="#stage4" role="tab" aria-controls="stage4" aria-selected="false">Etapa 4</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="stage5-tab" data-bs-toggle="tab" href="#stage5" role="tab" aria-controls="stage5" aria-selected="false">Etapa 5</a>
            </li>
        </ul>

        <!-- Contenido de las etapas -->
        <div class="tab-content">
            <!-- Etapa 1 -->
            <div class="tab-pane fade show active" id="stage1" role="tabpanel">
                <!-- Campos de etapa 1 -->
                <div class="form-group mt-3">
                    <label for="expediente">N° de Expediente</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                        <input type="text" class="form-control" id="expediente" name="expediente" value="{{ old('expediente') }}" readonly>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="fecha_ingreso">Fecha de Ingreso</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        <input type="text" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="{{ now() }}" readonly placeholder="DD/MM/AAAA">
                    </div>
                </div>
                <div class="form-group custom-input mt-3">
                    <label for="nombres">Nombres <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="nombres" name="nombres" value="{{ old('nombres') }}" required placeholder="Ingrese el primer y segundo nombre">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="apellidos">Apellidos</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required placeholder="Ingrese el primer y segundo apellido">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required onchange="calculateAge()" placeholder="DD/MM/AAAA">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="genero">Género</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                        <select class="form-control" id="genero" name="genero" required>
                            <option value="">Seleccione un género</option> <!-- Opción por defecto -->
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="direccion">Dirección</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-house"></i></span>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}" required placeholder="Ej. Calle Principal #123">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="edad">Edad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        <input type="text" class="form-control" id="edad" name="edad" value="{{ old('edad') }}" readonly>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-primary" type="button" onclick="nextTab('#stage2')">Siguiente</button>
                </div>
            </div>
            <!-- Etapa 2 -->
            <div class="tab-pane fade" id="stage2" role="tabpanel">
                <!-- Campos de etapa 2 -->
                <div class="form-group mt-3">
                    <label for="estado_civil">Estado Civil</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-heart"></i></span>
                        <select class="form-control" id="estado_civil" name="estado_civil" required>
                            <option value="soltero">Soltero</option>
                            <option value="casado">Casado</option>
                            <option value="viudo">Viudo</option>
                            <option value="divorciado">Divorciado</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="telefono">Teléfono</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="Ingrese el numero de telefono">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="celular">Celular</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                        <input type="text" class="form-control" id="celular" name="celular" value="{{ old('celular') }}" placeholder="Ingrese el celular">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="correo">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo') }}" placeholder="Ingrese el correo electronico">
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-secondary" type="button" onclick="prevTab('#stage1')">Anterior</button>
                    <button class="btn btn-primary" type="button" onclick="nextTab('#stage3')">Siguiente</button>
                </div>
            </div>
            <!-- Etapa 3 -->
            <div class="tab-pane fade" id="stage3" role="tabpanel">
                <!-- Datos de WhatsApp y contacto de emergencia -->
                <div class="form-group mt-3">
                    <label for="whatsapp">WhatsApp</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="Ingresa el numero de WhatsApp">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="emergencia_contacto">En caso de emergencia, contactar a</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="emergencia_contacto" name="emergencia_contacto" value="{{ old('emergencia_contacto') }}" placeholder="Nombre del contacto de emergencia">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="emergencia_telefono">Teléfono de emergencia</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" class="form-control" id="emergencia_telefono" name="emergencia_telefono" value="{{ old('emergencia_telefono') }}" placeholder="Ingresa el teléfono de emergencia">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="ha_visitado_odontologo">¿Ha visitado un odontólogo antes?</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                        <select class="form-control" id="ha_visitado_odontologo" name="ha_visitado_odontologo" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-secondary" type="button" onclick="prevTab('#stage2')">Anterior</button>
                    <button class="btn btn-primary" type="button" onclick="nextTab('#stage4')">Siguiente</button>
                </div>
            </div>

            <!-- Etapa 4 -->
            <div class="tab-pane fade" id="stage4" role="tabpanel">
                <br><h2 class="text-center font-weight-bold">Evaluación Sistémica del Paciente</h2><br>
                <h4>1. Historia de la Presente Enfermedad</h4>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                    <textarea class="form-control" name="historia_enfermedad" rows="3" placeholder="Describa la historia de la presente enfermedad">{{ old('historia_enfermedad') }}</textarea>
                </div>

                <br><h4>2. Historia Médica Personal</h4>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                    <textarea class="form-control" name="historia_medica_personal" rows="3" placeholder="Describa la historia médica personal">{{ old('historia_medica_personal') }}</textarea>
                </div>
                <br><h4>3. Antecedentes Médicos Familiares</h4>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                    <textarea class="form-control" name="antecedentes_medicos_familiares" rows="3" placeholder="Describa los antecedentes médicos familiares">{{ old('antecedentes_medicos_familiares') }}</textarea>
                </div>

                <br><h2 class="text-center font-weight-bold">Signos Vitales</h2><br>

                <div class="form-group mt-3">
                    <label for="pa">Presión Arterial</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-heart-pulse"></i></span>
                        <input type="text" class="form-control" id="pa" name="pa" value="{{ old('pa') }}" placeholder="Ej. 120/80 mmHg">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="pulso">Pulso</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-heart"></i></span>
                        <input type="text" class="form-control" id="pulso" name="pulso" value="{{ old('pulso') }}" placeholder="Ej. 72 latidos/min">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="temperatura">Temperatura</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-thermometer-half"></i></span>
                        <input type="text" class="form-control" id="temperatura" name="temperatura" placeholder="Ej. 37°C" value="{{ old('temperatura') }}">
                    </div>
                </div>

                <h2 class="text-center font-weight-bold">Exámenes Clínicos</h2>
                <h4>Examen Clínico Extraoral</h4>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                    <textarea class="form-control" name="examen_extraoral" rows="3" placeholder="Describa el examen clínico extraoral">{{ old('examen_extraoral') }}</textarea>
                </div>
                <br>
                <h4>Examen Clínico Intraoral</h4>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                    <textarea class="form-control" name="examen_intraoral" rows="3" placeholder="Describa el examen clínico intraoral">{{ old('examen_intraoral') }}</textarea>
                </div>
                    <button class="btn btn-secondary" type="button" onclick="prevTab('#stage3')">Anterior</button>
                    <button class="btn btn-primary" type="button" onclick="nextTab('#stage5')">Siguiente</button>
                </div>
            </div>
            <!-- Etapa 5 -->
            <div class="tab-pane fade" id="stage5" role="tabpanel">
                <h2 class="text-center font-weight-bold">Evaluación Regional</h2>

                <div class="form-group mt-3">
                    <label for="region">Región</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-map"></i></span>
                        <select class="form-control" id="region" name="region" required>
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
                </div>

                <div class="form-group mt-3">
                    <label for="condicion">Condición</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                        <select class="form-control" id="condicion" name="condicion">
                            <option value="">Selecciona una condición</option> <!-- Opción por defecto -->
                            <option value="normal">Normal</option>
                            <option value="anormal">Anormal</option>
                            <option value="no_acepta_revision">No Acepta Revisión</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="observacion">Observación</label>
                    <textarea class="form-control" id="observacion" name="observacion" rows="3" placeholder="Escriba su observación aquí..."></textarea>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-secondary" type="button" onclick="prevTab('#stage4')">Anterior</button>
                    <button class="btn btn-success" type="submit">Guardar Paciente</button>
                </div>
            </div>
            <div class="tab-pane fade" id="stage5" role="tabpanel">


                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-secondary" type="button" onclick="prevTab('#stage4')">Anterior</button>
                    <button class="btn btn-success" type="submit">Guardar Paciente</button>
                </div>
            </div>
        </div>
    </form>
    </div>
    
</div>

<script>
    function nextTab(tabId) {
        var currentTab = document.querySelector('.tab-pane.active');
        currentTab.classList.remove('show', 'active');

        var currentTabLink = document.querySelector('.nav-link.active');
        currentTabLink.classList.remove('active');

        var nextTab = document.querySelector(tabId);
        nextTab.classList.add('show', 'active');

        var nextTabLink = document.querySelector(tabId + '-tab');
        nextTabLink.classList.add('active');
    }

    function prevTab(tabId) {
        var currentTab = document.querySelector('.tab-pane.active');
        currentTab.classList.remove('show', 'active');

        var currentTabLink = document.querySelector('.nav-link.active');
        currentTabLink.classList.remove('active');

        var prevTab = document.querySelector(tabId);
        prevTab.classList.add('show', 'active');

        var prevTabLink = document.querySelector(tabId + '-tab');
        prevTabLink.classList.add('active');
    }

    function calculateAge() {
        var dob = new Date(document.getElementById('fecha_nacimiento').value);
        var today = new Date();
        var age = today.getFullYear() - dob.getFullYear();
        var monthDiff = today.getMonth() - dob.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        document.getElementById('edad').value = age;
    }
</script>

@endsection

