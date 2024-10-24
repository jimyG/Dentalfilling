@extends('layouts.menu')

@section('content')
    <div class="container">
    <div class="table-title">
            <h1>Generar Consentimiento Informado</h1>
        </div>

        <form action="{{ route('admin.consentimientos.store') }}" method="POST">
            @csrf

            <!-- Select de Médicos -->
            <div class="form-group">
                <label for="medico_id">Seleccione el Médico:</label>
                <select name="medico_id" id="medico_id" class="form-control" required>
                    <option value="">Seleccione un médico</option>
                    @foreach($medicos as $medico)
                        <option value="{{ $medico->id }}">{{ $medico->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Select de Pacientes -->
            <div class="form-group">
                <label for="patient_id">Seleccione el Paciente:</label>
                <select name="patient_id" id="patient_id" class="form-control" required>
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
                    Consentimiento Informado para Procedimientos Odontológicos
                    ...
                </textarea>
            </div>

            <button type="submit" class="btn btn-primary">Generar PDF</button>
        </form>
    </div>
@endsection
