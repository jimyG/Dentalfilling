@extends('layouts.menu')

@section('content')

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/libphonenumber-js/1.9.43/libphonenumber-js.min.js"></script>


</head>
<div class="container">
        <div id="title-wrapper" class="d-flex align-items-start">
            <a href="{{ url('/admin/patient') }}" id="icon-link" class="me-3">
                <div id="custom-icon-container">
                    <i class="bi bi-house-fill"></i>
                </div>
            </a>
            <div class="table-title">
                <h1>Crear Nuevo Paciente</h1>
            </div>
        </div>

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

            <!-- Campo Nombres -->
            <div class="form-group custom-input mt-3">
                <label for="nombres">Nombres <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="{{ old('nombres') }}" required placeholder="Ingrese el primer y segundo nombre">
                </div>
                @error('nombres')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo Apellidos -->
            <div class="form-group mt-3">
                <label for="apellidos">Apellidos <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required placeholder="Ingrese el primer y segundo apellido">
                </div>
                @error('apellidos')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo DUI -->
            <div class="form-group mt-3">
                <label for="dui">Dui <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                    <input type="text" class="form-control" id="dui" name="dui" value="{{ old('dui') }}" required placeholder="12345678-9"
                        pattern="^[0-9]{8}-[0-9]$" title="El DUI debe seguir el formato ########-#"
                        oninput="formatDUI(this)" maxlength="10">
                </div>
                @error('dui')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo Fecha de Nacimiento -->
            <div class="form-group mt-3">
                <label for="fecha_nacimiento">Fecha de Nacimiento <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required onchange="calculateAge()" placeholder="DD/MM/AAAA">
                </div>
                @error('fecha_nacimiento')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo Género -->
            <div class="form-group mt-3">
                <label for="genero">Género <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                    <select class="form-control" id="genero" name="genero" required>
                        <option value="">Seleccione un género</option>
                        <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                @error('genero')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo Dirección -->
            <div class="form-group mt-3">
                <label for="direccion">Dirección <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-house"></i></span>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}" required placeholder="Ej. Calle Principal #123">
                </div>
                @error('direccion')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo Edad -->
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
                    <label for="estado_civil">Estado Civil <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-heart"></i></span>
                        <select class="form-control" id="estado_civil" name="estado_civil" required>
                            <option value="soltero">Seleccione una opcion</option>
                            <option value="soltero">Soltero</option>
                            <option value="casado">Casado</option>
                            <option value="viudo">Viudo</option>
                            <option value="divorciado">Divorciado</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="telefono">Teléfono Fijo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="tel" class="form-control" id="phone" name="telefono" value="{{ old('telefono') }}" placeholder="Ingrese el telefono">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="celular">Celular <span class="text-danger">*</span></label></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                        <input type="tel" class="form-control" id="celular" name="celular" value="{{ old('celular') }}" placeholder="Ingrese el celular">
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
                        <input type="tel" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="Ingresa el WhatsApp">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="emergencia_contacto">En caso de emergencia, contactar a <span class="text-danger">*</span></label></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="emergencia_contacto" name="emergencia_contacto" value="{{ old('emergencia_contacto') }}" placeholder="Nombre del contacto de emergencia">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="emergencia_telefono">Teléfono de  contacto de emergencia <span class="text-danger">*</span></label></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="tel" class="form-control" id="emergencia_telefono" name="emergencia_telefono" value="{{ old('emergencia_telefono') }}" placeholder="teléfono de emergencia">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="ha_visitado_odontologo">¿Ha visitado un odontólogo antes? <span class="text-danger">*</span></label>
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

                <!-- Presión Arterial -->
                <div class="form-group mt-3">
                    <label for="pa">Presión Arterial <span class="text-danger">*</span></label></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-heart-pulse"></i></span>
                        <input type="text" class="form-control" id="pa" name="pa" value="{{ old('pa') }}" placeholder="Ej. 120/80 mmHg">
                    </div>
                </div>

                <!-- Pulso -->
                <div class="form-group mt-3">
                    <label for="pulso">Pulso <span class="text-danger">*</span></label></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-heart"></i></span>
                        <input type="text" class="form-control" id="pulso" name="pulso" value="{{ old('pulso') }}" placeholder="Ej. 72 latidos/min">
                    </div>
                </div>

                <!-- Temperatura -->
                <div class="form-group mt-3">
                    <label for="temperatura">Temperatura <span class="text-danger">*</span></label></label>
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
                <br><h4>Examen Clínico Intraoral</h4>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                    <textarea class="form-control" name="examen_intraoral" rows="3" placeholder="Describa el examen clínico intraoral">{{ old('examen_intraoral') }}</textarea>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-secondary" type="button" onclick="prevTab('#stage3')">Anterior</button>
                    <button class="btn btn-primary" type="button" onclick="nextTab('#stage5')">Siguiente</button>
                </div>
            </div>

            <!-- Etapa 5 -->
            <div class="tab-pane fade" id="stage5" role="tabpanel">
                <!-- Nueva sección de Enfermedades Comunes -->
                <h2 class="mt-5 text-center font-weight-bold">Enfermedades Cronicas</h2>

                <!-- Primera fila -->
                <div class="row mb-3">
                    <div class="col-md-3 col-6">
                        <label>Hipertensión Arterial: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="hipertension" value="si"> Sí</label>
                            <label><input type="radio" name="hipertension" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Diabetes Mellitus: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="diabetes" value="si"> Sí</label>
                            <label><input type="radio" name="diabetes" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Hemofilia (A, B): <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="hemofilia" value="si"> Sí</label>
                            <label><input type="radio" name="hemofilia" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Tumor labio, boca, faringe: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="tumor_labio" value="si"> Sí</label>
                            <label><input type="radio" name="tumor_labio" value="no"> No</label>
                        </div>
                    </div>
                </div>

                <!-- Segunda fila -->
                <div class="row mb-3">
                    <div class="col-12">
                        <label>Medicamento que toma: <span class="text-danger">*</span></label></label>
                        <input type="text" class="form-control" name="medicamento">
                    </div>
                </div>

                <!-- Tercera fila -->
                <div class="row mb-3">
                    <div class="col-md-3 col-6">
                        <label>Tumor cervico uterino: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="tumor_cervico" value="si"> Sí</label>
                            <label><input type="radio" name="tumor_cervico" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Síndrome de Down: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="sindrome_down" value="si"> Sí</label>
                            <label><input type="radio" name="sindrome_down" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Tumor mama: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="tumor_mama" value="si"> Sí</label>
                            <label><input type="radio" name="tumor_mama" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Tumor pulmón: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="tumor_pulmon" value="si"> Sí</label>
                            <label><input type="radio" name="tumor_pulmon" value="no"> No</label>
                        </div>
                    </div>
                </div>

                <!-- Cuarta fila -->
                <div class="row mb-3">
                    <div class="col-md-3 col-6">
                        <label>Autismo: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="autismo" value="si"> Sí</label>
                            <label><input type="radio" name="autismo" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Tumor colon y recto: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="tumor_colon" value="si"> Sí</label>
                            <label><input type="radio" name="tumor_colon" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Tumor estómago: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="tumor_estomago" value="si"> Sí</label>
                            <label><input type="radio" name="tumor_estomago" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Parálisis Cerebral: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="paralisis" value="si"> Sí</label>
                            <label><input type="radio" name="paralisis" value="no"> No</label>
                        </div>
                    </div>
                </div>

                <!-- Quinta fila -->
                <div class="row mb-3">
                    <div class="col-md-3 col-6">
                        <label>Enfermedad Renal Crónica (ERC): <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="erc" value="si"> Sí</label>
                            <label><input type="radio" name="erc" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Cardiopatía Isquémica: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="cardiopatia" value="si"> Sí</label>
                            <label><input type="radio" name="cardiopatia" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Endocarditis aguda y subaguda: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="endocarditis" value="si"> Sí</label>
                            <label><input type="radio" name="endocarditis" value="no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <label>Otros: <span class="text-danger">*</span></label></label>
                        <div>
                            <label><input type="radio" name="otros" value="si"> Sí</label>
                            <label><input type="radio" name="otros" value="no"> No</label>
                        </div>
                    </div>
            </div>

                <h2 class="text-center font-weight-bold">Evaluación Regional</h2>

                <div class="form-group mt-3">
                    <label for="region">Región <span class="text-danger">*</span></label>
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
                <label for="condicion">Condición <span class="text-danger">*</span></label>
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
                    <label for="observacion">Observación <span class="text-danger">*</span></label>
                    <div class="input group">
                        <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                        <textarea class="form-control" id="observacion" name="observacion" rows="3" placeholder="Escriba su observación aquí..."></textarea>

                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">

                    <!--<button class="btn btn-success" type="button" onclick="addRegion()">Agregar</button>-->
                </div>

                <!-- Aquí puedes incluir un contenedor para mostrar las regiones agregadas
                <div id="regionList" class="mt-3">
                    <h4>Regiones Agregadas:</h4>
                    <ul id="regionItems" class="list-group">
                        Aquí se agregarán dinámicamente los elementos
                    </ul>
                </div>-->
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-secondary" type="button" onclick="prevTab('#stage4')">Anterior</button>
                    
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>

            <!-- <script>
                function addRegion() {
                    var region = document.getElementById('region').value;
                    var condiciones = Array.from(document.querySelectorAll('input[name="condicion[]"]:checked')).map(el => el.nextSibling.textContent.trim());
                    var observacion = document.getElementById('observacion').value;

                    if (region && condiciones.length > 0 && observacion) {
                        var item = document.createElement('li');
                        item.className = 'list-group-item';
                        item.innerHTML = <strong>Región:</strong> ${region} <br><strong>Condición:</strong> ${condiciones.join(', ')} <br><strong>Observación:</strong> ${observacion} <button class="btn btn-danger btn-sm float-end" onclick="removeItem(this)">Eliminar</button>;
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
            </script>-->

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
function formatDUI(input) {
    // Remover todos los caracteres no numéricos excepto el guion
    let value = input.value.replace(/[^0-9]/g, '');
    // Insertar un guion antes del último dígito si tiene longitud de 9 caracteres
    if (value.length > 8) {
        input.value = value.slice(0, 8) + '-' + value.slice(8, 9);
    } else {
        input.value = value;
    }
}
</script>


<script>const input = document.querySelector("#phone");
window.intlTelInput(input, {
  initialCountry: "auto",
  geoIpLookup: callback => {
    fetch("https://ipapi.co/json")
      .then(res => res.json())
      .then(data => callback(data.country_code))
      .catch(() => callback("us"));
  },
  utilsScript: "/intl-tel-input/js/utils.js?1730730622316" // just for formatting/placeholders etc
});</script>

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

<!-- JavaScript -->
<script>
    // Selecciona todos los campos de entrada de teléfono
    const phoneInputs = ['#phone', '#celular', '#whatsapp', '#emergencia_telefono'];
    const itiInstances = {}; // Para almacenar instancias de intlTelInput

    // Configuración para cada input con intlTelInput
    phoneInputs.forEach(selector => {
        const input = document.querySelector(selector);
        if (input) {
            // Inicializa intlTelInput y guarda la instancia
            itiInstances[selector] = window.intlTelInput(input, {
                initialCountry: "auto",
                separateDialCode: true, // Prefijo dentro del campo visualmente
                geoIpLookup: callback => {
                    fetch("https://ipapi.co/json")
                        .then(res => res.json())
                        .then(data => callback(data.country_code))
                        .catch(() => callback("us"));
                },
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.js"
            });
        }
    });

    // Captura el envío del formulario
    document.querySelector("form").addEventListener("submit", function (e) {
        phoneInputs.forEach(selector => {
            const input = document.querySelector(selector);
            const iti = itiInstances[selector];
            
            if (input && iti) {
                // Obtiene el número completo (con prefijo)
                const fullNumber = iti.getNumber();
                
                // Si el número es válido, reemplaza el valor del input con el número completo
                if (iti.isValidNumber()) {
                    input.value = fullNumber;
                } else {
                    // Si no es válido, evita el envío del formulario
                    e.preventDefault();
                    alert(`El número ingresado en ${selector} no es válido.`);
                }
            }
        });
    });
</script>


<script>
    const paInput = document.querySelector("#pa");

paInput.addEventListener("input", function () {
    let value = paInput.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos

    // Limitar la longitud del valor a 6 dígitos (sin contar el '/')
    if (value.length > 6) {
        value = value.slice(0, 6); // Limitar a 6 caracteres numéricos
    }

    // Si la longitud es mayor a 3, insertar '/' entre los números
    if (value.length > 3) {
        value = value.slice(0, 3) + '/' + value.slice(3, 5); // Insertar '/' después del tercer carácter y mostrar solo los primeros dos dígitos después del '/'
    }

    // Asegurarse de que siempre tenga el sufijo " mmHg" cuando se haya ingresado un número completo
    if (value.length === 5) {
        value = value + ' mmHg'; // Agregar mmHg al final
    }

    // Actualizar el valor en el input
    paInput.value = value;

    // Si el campo ya tiene 6 caracteres numéricos más " mmHg", no permitir más ingreso de números
    if (value.replace(/\D/g, '').length === 6) {
        paInput.setAttribute('maxlength', '8'); // Limitar la longitud máxima a 8 caracteres (el total con mmHg)
    }
});

// Si se borra el contenido, permitir ingresar nuevamente hasta el formato completo
paInput.addEventListener("keydown", function (e) {
    // Permitir borrar todo el contenido
    if (e.key === "Backspace" || e.key === "Delete") {
        paInput.removeAttribute('maxlength');
    }
});

const pulsoInput = document.querySelector("#pulso");

    pulsoInput.addEventListener("input", function () {
        let value = pulsoInput.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos

        // Si tiene 2 o 3 dígitos, agregar automáticamente " latidos/min"
        if (value.length >= 2 && value.length <= 3) {
            value = value + ' latidos/min'; // Agregar " latidos/min" automáticamente
        }

        // Limitar el número de dígitos a 3 y evitar que el usuario ingrese más de eso
        if (value.length > 6) {
            value = value.slice(0, 6); // Limitar a 6 caracteres en total (3 dígitos y " latidos/min")
        }

        pulsoInput.value = value;
    });

    // Formato para Temperatura (37°C)
    const temperaturaInput = document.querySelector("#temperatura");
    temperaturaInput.addEventListener("input", function () {
        let value = temperaturaInput.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
        if (value.length > 1) {
            value = value.slice(0, 2) + '°C'; // Insertar "°C"
        }
        temperaturaInput.value = value;
    });
</script>


@endsection

