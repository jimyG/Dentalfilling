@extends('layouts.pdf') <!-- Si tienes un layout específico para PDFs -->

@section('content')
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <style>
            h1 {
                text-align: center;
                margin: 0 auto;
                margin-bottom: 20px;
            }
            /* Añade tus estilos aquí, asegúrate de que sean compatibles con la impresión */
            /* Por ejemplo: */
            #titulo-odontograma {
                text-align: center;
                margin-bottom: 20px;
                font-size: 32px;
            }
            /* ...otros estilos... */
        </style>
    </head>

    <div class="container">
        <h1 id="titulo-odontograma">Odontograma de {{ $paciente->nombres }}</h1>

        <div id="odontograma">
            <!-- Aquí va el contenido del odontograma -->
            <div class="cuadrante">
                @for($i = 1; $i <= 8; $i++)
                    <div class="diente" data-diente="{{ $i }}">
                        <div class="numero-diente">{{ $i }}</div>
                        <div class="area" data-area="superior" style="background-color: {{ getTreatmentColor($i, 'superior', $tratamientos) }}">U</div>
                        <div class="area" data-area="izquierda" style="background-color: {{ getTreatmentColor($i, 'izquierda', $tratamientos) }}">I</div>
                        <div class="area" data-area="centro" style="background-color: {{ getTreatmentColor($i, 'centro', $tratamientos) }}">C</div>
                        <div class="area" data-area="derecha" style="background-color: {{ getTreatmentColor($i, 'derecha', $tratamientos) }}">D</div>
                        <div class="area" data-area="inferior" style="background-color: {{ getTreatmentColor($i, 'inferior', $tratamientos) }}">L</div>
                    </div>
                @endfor
            </div>
            <!-- Repite para otros cuadrantes -->
        </div>
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
