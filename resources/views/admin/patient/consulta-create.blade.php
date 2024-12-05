@extends('layouts.menu')

@section('content')

<div class="container"> 

    <div id="title-wrapper" class="d-flex align-items-start">
            <a href="{{ url('/admin/patient') }}" id="icon-link" class="me-3">
                    <div id="custom-icon-container">
                        <i class="bi bi-house-fill"></i>
                    </div>
                </a>
            <div class="table-title">   
                <h1 class="text-center">Nueva Consulta</h>
            </div>
        </div>
        

            <h4 class="mb-4">Datos del Paciente</h4>
                
            <div class="patient-info p-4 bg-light border rounded mb-5">
                <p>
                    <i class="bi bi-person-fill color-icon"></i> 
                    <strong>Nombre:</strong> {{ $patient->nombres }} {{ $patient->apellidos }}
                </p>
                <p>
                    <i class="bi bi-calendar-fill color-icon"></i> 
                    <strong>Edad:</strong> {{ $patient->edad }} años
                </p>
                <p>
                    <i class="bi bi-credit-card-fill color-icon"></i> 
                    <strong>DUI:</strong> {{ $patient->dui }}
                </p>
                <p>
                    <i class="bi bi-gender-ambiguous color-icon"></i> 
                    <strong>Sexo:</strong> {{ $patient->genero }}
                </p>
                <p>
                    <i class="bi bi-calendar-check-fill color-icon"></i> 
                    <strong>Última Consulta:</strong> {{ $ultimaConsultaFecha }}
                </p>
            </div>
    
            <form action="{{ route('admin.patient.consulta-store', $patient->id) }}" method="POST">
                @csrf

                <div class="form-row mb-3">
                    <!-- Presión Arterial -->
                    <div class="col-md-4">
                        <label for="presion_arterial" class="form-label">
                            <i class="bi bi-heart-pulse-fill color-icon-consulta"></i> Presión Arterial
                        </label>
                        <input type="text" id="presion_arterial" name="presion_arterial" class="form-control" placeholder="Ej. 120/80" 
                            oninput="formatPresionArterial(this)">
                    </div>

                    <!-- Pulso -->
                    <div class="col-md-4">
                        <label for="pulso" class="form-label">
                            <i class="bi bi-heart color-icon-consulta"></i> Pulso
                        </label>
                        <input type="text" id="pulso" name="pulso" class="form-control" placeholder="Ej. 75 bpm" 
                            oninput="addBpm(this)">
                    </div>

                    <!-- Temperatura -->
                    <div class="col-md-4">
                        <label for="temperatura " class="form-label">
                            <i class="bi bi-thermometer-half color-icon-consulta"></i> Temperatura
                        </label>
                        <input type="text" id="temperatura" name="temperatura" class="form-control" placeholder="Ej. 37°C" 
                            oninput="addCelsius(this)">
                    </div>
                </div>



                <div class="form-group">
                    <label for="motivo_consulta">Motivo de la Consulta</label>
                    <textarea name="motivo_consulta" id="motivo_consulta" class="form-control" rows="3" required></textarea>
                </div>

                <!-- Campo de Tratamiento a Realizar -->
                <div class="form-group">
                    <label for="tratamiento_dental_id">Tratamiento a Realizar (si lo requiere).</label>
                    <select name="tratamiento_dental_id" id="tratamiento_dental_id" class="col-md-4">
                        <option value="">Selecciona un tratamiento</option>
                        @foreach ($tratamientos_dentales as $tratamiento)
                            <option value="{{ $tratamiento->id }}">{{ $tratamiento->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="diagnostico">Diagnóstico</label>
                    <textarea name="diagnostico" id="diagnostico" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="tratamiento_propuesto">Tratamiento Propuesto</label>
                    <textarea name="tratamiento_propuesto" id="tratamiento_propuesto" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Consulta</button>
            </form>

</div>

<script>
    // Formatea la presión arterial en el formato "sistólica/diastólica"
    function formatPresionArterial(input) {
        let value = input.value.replace(/[^0-9/]/g, ''); // Elimina cualquier carácter que no sea dígito o '/'
        if (value.includes('/')) {
            const [sistolica, diastolica] = value.split('/');
            input.value = `${sistolica}/${diastolica}`;
        } else {
            input.value = value;
        }
    }

    // Agrega "bpm" automáticamente para el pulso
    function addBpm(input) {
        input.value = input.value.replace(/[^0-9]/g, '') + " bpm";
    }

    // Agrega "°C" automáticamente para la temperatura
    function addCelsius(input) {
        input.value = input.value.replace(/[^0-9.]/g, '') + "°C";
    }
</script>

@endsection
