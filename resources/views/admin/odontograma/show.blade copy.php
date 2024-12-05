@extends('layouts.menu')

@section('content')
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        h1 {
            text-align: center;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        #titulo-odontograma {
        text-align: center;
        margin-bottom: 20px;
        font-size: 32px; /* Ajusta el tamaño de fuente según sea necesario */

    }
        #odontograma {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 columnas de cuadrantes */
            grid-template-rows: repeat(2, 1fr); /* 2 filas de cuadrantes */
            gap: 30px; /* Espacio entre cuadrantes */
        }

        .cuadrante {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #fafafa;
            display: grid;
            grid-template-columns: repeat(8, 1fr); /* 8 dientes en fila por cuadrante */
            gap: 10px; /* Espacio entre dientes */
        }

        .diente {
            width: 50px; /* Tamaño ajustado de los dientes */
            height: 60px;
            border: 2px solid #333;
            border-radius: 50%;
            display: grid;
            grid-template-rows: 1fr 1fr 1fr;
            grid-template-columns: 1fr 1fr 1fr;
            position: relative;
            background-color: #fafafa;
            transition: transform 0.3s ease;
        }

        .diente:hover {
            transform: scale(1.1);
        }

        .area {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ccc;
            cursor: pointer;
            text-align: center;
            font-size: 10px;
            background-color: #f0f0f0;
            transition: background-color 0.3s ease;
        }

        .area[data-area="superior"] {
            grid-column: 1 / span 3;
            grid-row: 1;
            border-top-left-radius: 20%;
            border-top-right-radius: 20%;
        }

        .area[data-area="izquierda"] {
            grid-column: 1;
            grid-row: 2;
        }

        .area[data-area="centro"] {
            grid-column: 2;
            grid-row: 2;
        }

        .area[data-area="derecha"] {
            grid-column: 3;
            grid-row: 2;
        }

        .area[data-area="inferior"] {
            grid-column: 1 / span 3;
            grid-row: 3;
            border-bottom-left-radius: 40%;
            border-bottom-right-radius: 40%;
        }

        .numero-diente {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #0c9ecf;
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
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
        <a href="" class="btn btn-secondary">
            <i class="bi bi-printer"></i> Imprimir
        </a>
    </div>

    <h1 id="titulo-odontograma">Odontograma de {{ $paciente->nombres}}</h1>

    <div id="odontograma">
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

        <div class="cuadrante">
            @for($i = 9; $i <= 16; $i++)
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

        <div class="cuadrante">
            @for($i = 17; $i <= 24; $i++)
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

        <div class="cuadrante">
            @for($i = 25; $i <= 32; $i++)
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