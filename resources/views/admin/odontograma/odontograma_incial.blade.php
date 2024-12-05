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
            font-size: 32px;
        }
        #odontograma {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 30px;
        }

        .cuadrante {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #fafafa;
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 10px;
        }

        .diente {
            width: 50px;
            height: 60px;
            border: 0px solid #ffffff;
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
            border-top-left-radius: 90%;
            border-top-right-radius: 90%;
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
            border-bottom-left-radius: 90%;
            border-bottom-right-radius: 90%;
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
        <h1>Odontograma Inicial</h1>
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

    <h1 id="titulo-odontograma">Odontograma Inicial de {{ $paciente->nombres }}</h1>

    <div id="odontograma">
        @php
            // Asegúrate de que la función no esté ya definida
            if (!function_exists('getTreatmentColor')) {
                function getTreatmentColor($diente, $area, $tratamientos)
                {
                    // Buscar el tratamiento correspondiente
                    $tratamiento = $tratamientos->firstWhere('diente', $diente)->where('area', $area);
                    // Obtener el color o usar un color predeterminado
                    return $tratamiento ? $tratamiento->color : 'transparent'; // Cambiar 'transparent' por el color que desees
                }
            }
        @endphp

        @foreach (range(1, 8) as $i)
            <div class="cuadrante">
                <div class="diente" data-diente="{{ $i }}">
                    <div class="numero-diente">{{ $i }}</div>
                    @foreach (['superior', 'izquierda', 'centro', 'derecha', 'inferior'] as $area)
                        <div class="area" data-area="{{ $area }}" style="background-color: {{ getTreatmentColor($i, $area, $tratamientos) }}">{{ strtoupper(substr($area, 0, 1)) }}</div>
                    @endforeach
                </div>
            </div>
        @endforeach

        @foreach (range(9, 16) as $i)
            <div class="cuadrante">
                <div class="diente" data-diente="{{ $i }}">
                    <div class="numero-diente">{{ $i }}</div>
                    @foreach (['superior', 'izquierda', 'centro', 'derecha', 'inferior'] as $area)
                        <div class="area" data-area="{{ $area }}" style="background-color: {{ getTreatmentColor($i, $area, $tratamientos) }}">{{ strtoupper(substr($area, 0, 1)) }}</div>
                    @endforeach
                </div>
            </div>
        @endforeach

        @foreach (range(17, 24) as $i)
            <div class="cuadrante">
                <div class="diente" data-diente="{{ $i }}">
                    <div class="numero-diente">{{ $i }}</div>
                    @foreach (['superior', 'izquierda', 'centro', 'derecha', 'inferior'] as $area)
                        <div class="area" data-area="{{ $area }}" style="background-color: {{ getTreatmentColor($i, $area, $tratamientos) }}">{{ strtoupper(substr($area, 0, 1)) }}</div>
                    @endforeach
                </div>
            </div>
        @endforeach

        @foreach (range(25, 32) as $i)
            <div class="cuadrante">
                <div class="diente" data-diente="{{ $i }}">
                    <div class="numero-diente">{{ $i }}</div>
                    @foreach (['superior', 'izquierda', 'centro', 'derecha', 'inferior'] as $area)
                        <div class="area" data-area="{{ $area }}" style="background-color: {{ getTreatmentColor($i, $area, $tratamientos) }}">{{ strtoupper(substr($area, 0, 1)) }}</div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
