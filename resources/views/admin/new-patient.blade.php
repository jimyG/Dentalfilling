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

    <form action="{{ route('patients.store') }}" method="POST">
        @csrf

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
                    <input type="text" class="form-control" id="expediente" name="expediente" value="{{ old('expediente') }}" readonly>
                </div>
                <div class="form-group mt-3">
                    <label for="fecha_ingreso">Fecha de Ingreso</label>
                    <input type="text" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="{{ now() }}" disabled>
                </div>
                <div class="form-group mt-3">
                    <label for="nombres">Nombres</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="{{ old('nombres') }}" required>
                </div>
                <div class="form-group mt-3">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required>
                </div>
                <div class="form-group mt-3">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required onchange="calculateAge()">
                </div>
                <div class="form-group mt-3">
                    <label for="genero">Género</label>
                    <select class="form-control" id="genero" name="genero" required>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="edad">Edad</label>
                    <input type="text" class="form-control" id="edad" name="edad" value="{{ old('edad') }}" disabled>
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
                    <select class="form-control" id="estado_civil" name="estado_civil" required>
                        <option value="soltero">Soltero</option>
                        <option value="casado">Casado</option>
                        <option value="viudo">Viudo</option>
                        <option value="divorciado">Divorciado</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
                </div>
                <div class="form-group mt-3">
                    <label for="celular">Celular</label>
                    <input type="text" class="form-control" id="celular" name="celular" value="{{ old('celular') }}">
                </div>
                <div class="form-group mt-3">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo') }}">
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
                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}">
                </div>
                <div class="form-group mt-3">
                    <label for="emergencia_contacto">En caso de emergencia, contactar a</label>
                    <input type="text" class="form-control" id="emergencia_contacto" name="emergencia_contacto" value="{{ old('emergencia_contacto') }}">
                </div>
                <div class="form-group mt-3">
                    <label for="emergencia_telefono">Teléfono de emergencia</label>
                    <input type="text" class="form-control" id="emergencia_telefono" name="emergencia_telefono" value="{{ old('emergencia_telefono') }}">
                </div>
                <div class="form-group mt-3">
                    <label for="ha_visitado_odontologo">¿Ha visitado un odontólogo antes?</label>
                    <select class="form-control" id="ha_visitado_odontologo" name="ha_visitado_odontologo" required>
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
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
                <textarea class="form-control" name="historia_enfermedad" rows="3" placeholder="Describa la historia de la presente enfermedad">{{ old('historia_enfermedad') }}</textarea>

                <br><h4>2. Historia Médica Personal</h4>
                <textarea class="form-control" name="historia_medica_personal" rows="3" placeholder="Describa la historia médica personal">{{ old('historia_medica_personal') }}</textarea>

                <br><h4>3. Antecedentes Médicos Familiares</h4>
                <textarea class="form-control" name="antecedentes_medicos_familiares" rows="3" placeholder="Describa los antecedentes médicos familiares">{{ old('antecedentes_medicos_familiares') }}</textarea>


                <br><h2 class="text-center font-weight-bold">Signos Vitales</h2><br>

                <div class="form-group mt-3">
                    <label for="pa">Presión Arterial</label>
                    <input type="text" class="form-control" id="pa" name="pa" value="{{ old('pa') }}">
                </div>
                <div class="form-group mt-3">
                    <label for="pulso">Pulso</label>
                    <input type="text" class="form-control" id="pulso" name="pulso" value="{{ old('pulso') }}">
                </div>
                <div class="form-group mt-3">
                    <label for="temperatura">Temperatura</label>
                    <input type="text" class="form-control" id="temperatura" name="temperatura"
                    placeholder="Ej. 37°C" value="{{ old('temperatura') }}">
                </div>

                <h2 class="text-center font-weight-bold">Exámenes Clínicos</h2>
                <h4>Examen Clínico Extraoral</h4>
                <textarea class="form-control" name="examen_extraoral" rows="3" placeholder="Describa el examen clínico extraoral">{{ old('examen_extraoral') }}</textarea>

                <br><h4>Examen Clínico Intraoral</h4>
                <textarea class="form-control" name="examen_intraoral" rows="3" placeholder="Describa el examen clínico intraoral">{{ old('examen_intraoral') }}</textarea>
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-secondary" type="button" onclick="prevTab('#stage3')">Anterior</button>
                    <button class="btn btn-primary" type="button" onclick="nextTab('#stage5')">Siguiente</button>
                </div>
            </div>

            <!-- Etapa 5 -->
            <!-- Etapa 5 -->
<div class="tab-pane fade" id="stage5" role="tabpanel">
    <h2 class="text-center font-weight-bold">Evaluación Regional</h2>

    <div class="form-group mt-3">
        <label for="region">Región</label>
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

    <div class="form-group mt-3">
        <label>Condición</label><br>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="condicion_normal" name="condicion[]" value="normal">
            <label class="form-check-label" for="condicion_normal">Normal</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="condicion_anormal" name="condicion[]" value="anormal">
            <label class="form-check-label" for="condicion_anormal">Anormal</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="no_acepta_revision" name="condicion[]" value="no_acepta_revision">
            <label class="form-check-label" for="no_acepta_revision">No Acepta Revisión</label>
        </div>
    </div>

    <div class="form-group mt-3">
        <label for="observacion">Observación</label>
        <textarea class="form-control" id="observacion" name="observacion" rows="3" placeholder="Escriba su observación aquí..."></textarea>
    </div>

    <div class="d-flex justify-content-between mt-3">

        <button class="btn btn-success" type="button" onclick="addRegion()">Agregar</button>
    </div>

    <!-- Aquí puedes incluir un contenedor para mostrar las regiones agregadas -->
    <div id="regionList" class="mt-3">
        <h4>Regiones Agregadas:</h4>
        <ul id="regionItems" class="list-group">
            <!-- Aquí se agregarán dinámicamente los elementos -->
        </ul>
    </div>
    <div class="d-flex justify-content-between mt-3">
        <button class="btn btn-secondary" type="button" onclick="prevTab('#stage4')">Anterior</button>
        <button class="btn btn-success" type="submit">Guardar Paciente</button>
    </div>
</div>



<script>
    function addRegion() {
        var region = document.getElementById('region').value;
        var condiciones = Array.from(document.querySelectorAll('input[name="condicion[]"]:checked')).map(el => el.nextSibling.textContent.trim());
        var observacion = document.getElementById('observacion').value;

        if (region && condiciones.length > 0 && observacion) {
            var item = document.createElement('li');
            item.className = 'list-group-item';
            item.innerHTML = `<strong>Región:</strong> ${region} <br><strong>Condición:</strong> ${condiciones.join(', ')} <br><strong>Observación:</strong> ${observacion} <button class="btn btn-danger btn-sm float-end" onclick="removeItem(this)">Eliminar</button>`;
            document.getElementById('regionItems').appendChild(item);

            // Limpiar los campos después de agregar
            document.getElementById('region').value = '';
            document.querySelectorAll('input[name="condicion[]"]:checked').forEach(el => el.checked = false);
            document.getElementById('observacion').value = '';
        } else {
            alert('Por favor complete todos los campos antes de agregar.');
        }
    }

    function removeItem(button) {
        button.parentElement.remove();
    }
</script>

            <div class="tab-pane fade" id="stage5" role="tabpanel">


                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-secondary" type="button" onclick="prevTab('#stage4')">Anterior</button>
                    <button class="btn btn-success" type="submit">Guardar Paciente</button>
                </div>
            </div>
        </div>
    </form>
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

