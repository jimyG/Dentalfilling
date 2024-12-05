@extends('layouts.menu')

@section('content')
<div class="container">

    <div id="title-wrapper" class="d-flex align-items-start">
        <a href="{{ route('admin.consentimientos.index') }}" id="icon-link" class="me-3">
            <div id="custom-icon-container">
                <i class="bi bi-house-fill"></i>
            </div>
        </a>
        <div class="table-title">
            <h1>Generar Consentimiento Informado</h1>
        </div>
    </div>

    <form action="{{ route('admin.consentimientos.store') }}" method="POST">
        @csrf

        <!-- Select de Médicos -->
        <div class="form-group">
            <label for="medico_id">Seleccione el Médico:</label>
            <select name="medico_id" id="medico_id" class="js-example-basic-single" name="state" required>
                <option value="">Seleccione un médico</option>
                @foreach($medicos as $medico)
                <option value="{{ $medico->id }}">{{ $medico->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select de Pacientes -->
        <div class="form-group">
            <label for="patient_id">Seleccione el Paciente:</label>
            <select name="patient_id" id="patient_id" class="js-example-basic-single" name="state" required>
                <option value="">Seleccione un paciente</option>
                @foreach($patients as $patient)
                <option value="{{ $patient->id }}">{{ $patient->nombres }} {{ $patient->apellidos }}</option>
                @endforeach
            </select>
        </div>

        <!-- Área de texto para el contenido -->
        <div class="form-group">
            <label for="contenido">Contenido del Consentimiento:</label>
            <textarea name="contenido" id="contenido" class="form-control" rows="10" required>
                    consentimiento 
                </textarea>
        </div>

        <button type="submit" class="btn btn-primary">Generar PDF</button>
    </form>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection
