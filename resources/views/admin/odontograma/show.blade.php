@extends('layouts.menu')

@section('content')
<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Otros enlaces de CSS/JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <style>
        h1 {
            text-align: center;
            margin: 0 auto 20px;
        }

        .creation-date {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

    </style>
</head>

<div class="container" style="padding: 20px; border-radius: 10px;">
    <div class="table-title">
        <h1>Odontograma</h1>
    </div>

    <div class="header-form d-flex justify-content-between mb-3">
        <a href="{{ route('admin.odontograma.index') }}" id="icon-link" class="me-3">
            <div id="custom-icon-container">
                <i class="bi bi-house-fill"></i>
            </div>
        </a>
       
    </div>

    <h1 id="titulo-odontograma">Odontograma de {{ $paciente->nombres}}</h1>
    <div class="creation-date">
        Fecha de creación: {{ $odontograma->created_at->format('d/m/Y') }}
    </div>


    <!-- Odontograma -->
    <div class="odontograma">
        <div class="cuadrante" id="cuadrante1">
        <h3>Cuadrante I</h3>
        <div class="dientes">
            @for ($i = 1; $i <= 5; $i++)
            <div class="diente" data-diente="{{ $i }}">

                <div class="area" data-area="superior" style="background-color: {{ getTreatmentColor($i, 'superior', $tratamientos) }}">V</div>
                <div class="area" data-area="izquierda" style="background-color: {{ getTreatmentColor($i, 'izquierda', $tratamientos) }}">D</div>
                <div class="area" data-area="centro" style="background-color: {{ getTreatmentColor($i, 'centro', $tratamientos) }}">O</div>
                <div class="area" data-area="derecha" style="background-color: {{ getTreatmentColor($i, 'derecha', $tratamientos) }}">M</div>
                <div class="area" data-area="inferior" style="background-color: {{ getTreatmentColor($i, 'inferior', $tratamientos) }}">L</div>
            </div>
            @endfor
            @for ($i = 6; $i <= 8; $i++)
            <div class="diente" data-diente="{{ $i }}">

                <div class="area" data-area="superior" style="background-color: {{ getTreatmentColor($i, 'superior', $tratamientos) }}">V</div>
                <div class="area" data-area="izquierda" style="background-color: {{ getTreatmentColor($i, 'izquierda', $tratamientos) }}">D</div>
                <div class="area" data-area="centro" style="background-color: {{ getTreatmentColor($i, 'centro', $tratamientos) }}">I</div>
                <div class="area" data-area="derecha" style="background-color: {{ getTreatmentColor($i, 'derecha', $tratamientos) }}">M</div>
                <div class="area" data-area="inferior" style="background-color: {{ getTreatmentColor($i, 'inferior', $tratamientos) }}">L</div>
            </div>
            @endfor
        </div>
    </div>
    <div class="cuadrante" id="cuadrante2">
        <h3>Cuadrante II</h3>
        <div class="dientes">
            @for ($i = 9; $i <= 11; $i++)
            <div class="diente" data-diente="{{ $i }}">

                <div class="area" data-area="superior" style="background-color: {{ getTreatmentColor($i, 'superior', $tratamientos) }}">V</div>
                <div class="area" data-area="izquierda" style="background-color: {{ getTreatmentColor($i, 'izquierda', $tratamientos) }}">M</div>
                <div class="area" data-area="centro" style="background-color: {{ getTreatmentColor($i, 'centro', $tratamientos) }}">I</div>
                <div class="area" data-area="derecha" style="background-color: {{ getTreatmentColor($i, 'derecha', $tratamientos) }}">D</div>
                <div class="area" data-area="inferior" style="background-color: {{ getTreatmentColor($i, 'inferior', $tratamientos) }}">L</div>
            </div>
            @endfor

            @for ($i = 12; $i <= 16; $i++)
            <div class="diente" data-diente="{{ $i }}">

                <div class="area" data-area="superior" style="background-color: {{ getTreatmentColor($i, 'superior', $tratamientos) }}">V</div>
                <div class="area" data-area="izquierda" style="background-color: {{ getTreatmentColor($i, 'izquierda', $tratamientos) }}">M</div>
                <div class="area" data-area="centro" style="background-color: {{ getTreatmentColor($i, 'centro', $tratamientos) }}">O</div>
                <div class="area" data-area="derecha" style="background-color: {{ getTreatmentColor($i, 'derecha', $tratamientos) }}">D</div>
                <div class="area" data-area="inferior" style="background-color: {{ getTreatmentColor($i, 'inferior', $tratamientos) }}">L</div>
            </div>
            @endfor
        </div>
    </div>


    <div class="cuadrante" id="cuadrante3">
        <h3>Cuadrante IV</h3>
        <div class="dientes">
            @for ($i = 25; $i <= 29; $i++)
            <div class="diente" data-diente="{{ $i }}">

                <div class="area" data-area="superior" style="background-color: {{ getTreatmentColor($i, 'superior', $tratamientos) }}">V</div>
                <div class="area" data-area="izquierda" style="background-color: {{ getTreatmentColor($i, 'izquierda', $tratamientos) }}">D</div>
                <div class="area" data-area="centro" style="background-color: {{ getTreatmentColor($i, 'centro', $tratamientos) }}">O</div>
                <div class="area" data-area="derecha" style="background-color: {{ getTreatmentColor($i, 'derecha', $tratamientos) }}">M</div>
                <div class="area" data-area="inferior" style="background-color: {{ getTreatmentColor($i, 'inferior', $tratamientos) }}">L</div>
            </div>
            @endfor

            @for ($i = 30; $i <= 32; $i++)
            <div class="diente" data-diente="{{ $i }}">

                <div class="area" data-area="superior" style="background-color: {{ getTreatmentColor($i, 'superior', $tratamientos) }}">V</div>
                <div class="area" data-area="izquierda" style="background-color: {{ getTreatmentColor($i, 'izquierda', $tratamientos) }}">D</div>
                <div class="area" data-area="centro" style="background-color: {{ getTreatmentColor($i, 'centro', $tratamientos) }}">I</div>
                <div class="area" data-area="derecha" style="background-color: {{ getTreatmentColor($i, 'derecha', $tratamientos) }}">M</div>
                <div class="area" data-area="inferior" style="background-color: {{ getTreatmentColor($i, 'inferior', $tratamientos) }}">L</div>
            </div>
            @endfor
        </div>
    </div>


<div class="cuadrante" id="cuadrante4">
    <h3>Cuadrante III</h3>
    <div class="dientes">
        @for ($i = 17; $i <= 19; $i++)
        <div class="diente" data-diente="{{ $i }}">

            <div class="area" data-area="superior" style="background-color: {{ getTreatmentColor($i, 'superior', $tratamientos) }}">V</div>
            <div class="area" data-area="izquierda" style="background-color: {{ getTreatmentColor($i, 'izquierda', $tratamientos) }}">M</div>
            <div class="area" data-area="centro" style="background-color: {{ getTreatmentColor($i, 'centro', $tratamientos) }}">I</div>
            <div class="area" data-area="derecha" style="background-color: {{ getTreatmentColor($i, 'derecha', $tratamientos) }}">D</div>
            <div class="area" data-area="inferior" style="background-color: {{ getTreatmentColor($i, 'inferior', $tratamientos) }}">L</div>
        </div>
    @endfor

    @for ($i = 20; $i <= 24; $i++)
    <div class="diente" data-diente="{{ $i }}">

        <div class="area" data-area="superior" style="background-color: {{ getTreatmentColor($i, 'superior', $tratamientos) }}">V</div>
        <div class="area" data-area="izquierda" style="background-color: {{ getTreatmentColor($i, 'izquierda', $tratamientos) }}">M</div>
        <div class="area" data-area="centro" style="background-color: {{ getTreatmentColor($i, 'centro', $tratamientos) }}">O</div>
        <div class="area" data-area="derecha" style="background-color: {{ getTreatmentColor($i, 'derecha', $tratamientos) }}">D</div>
        <div class="area" data-area="inferior" style="background-color: {{ getTreatmentColor($i, 'inferior', $tratamientos) }}">L</div>
    </div>
    @endfor
    </div>
</div>

</div>
<br><br>

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




@php
function getTreatmentColor($diente, $area, $tratamientos) {
    foreach ($tratamientos as $tratamiento) {
        if ($tratamiento->diente == $diente && $tratamiento->area == $area) {
            return $tratamiento->color;
        }
    }
    return '#f0f0f0'; // Color por defecto si no hay tratamiento
}
@endphp

@endsection
