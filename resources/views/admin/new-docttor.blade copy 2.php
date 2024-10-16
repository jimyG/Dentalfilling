@extends('layouts.menu')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery-1.9.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odontograma</title>
    <style>
        body {
            padding-top: 70px; /* Ajusta el padding superior para dejar espacio para el menú */
            min-height: 100vh; /* Asegura que el cuerpo ocupe al menos el 100% de la altura de la ventana */
        }
        .cuadrante {
            border: 1px solid #000; /* Borde alrededor del cuadrante */
            padding: 10px; /* Espacio interno */
            text-align: center; /* Centra el texto y la imagen */
            margin-bottom: 20px; /* Espacio entre cuadrantes */
        }
        #odontogram {
            margin-top: 20px; /* Espacio superior para separar del contenido anterior */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <!-- Cuadrante 1 -->
            <div class="col-md-6">
                <div class="cuadrante">
                    <h5>Cuadrante 1</h5>
                    <?php 
                        for($j=1; $j <= 8; $j++): // 8 imágenes para el cuadrante 1
                    ?>
                        <a href="" class="VectorD" valor="<?php echo $j; ?>">
                            <img src="{{ asset('img/cuadrante.jpeg') }}" width="70px" alt="cuadrante" class="vector">
                        </a>
                    <?php endfor; ?>
                </div>
                <div class="cuadrante">
                    <h5>Cuadrante 2</h5>
                    <?php 
                        for($j=9; $j <= 16; $j++): // 8 imágenes para el cuadrante 2
                    ?>
                        <a href="" class="VectorD" valor="<?php echo $j; ?>">
                            <img src="{{ asset('img/cuadrante.jpeg') }}" width="70px" alt="cuadrante" class="vector">
                        </a>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Cuadrante 3 -->
            <div class="col-md-6">
                <div class="cuadrante">
                    <h5>Cuadrante 3</h5>
                    <?php 
                        for($j=17; $j <= 24; $j++): // 8 imágenes para el cuadrante 3
                    ?>
                        <a href="" class="VectorD" valor="<?php echo $j; ?>">
                            <img src="{{ asset('img/cuadrante.jpeg') }}" width="70px" alt="cuadrante" class="vector">
                        </a>
                    <?php endfor; ?>
                </div>
                <div class="cuadrante">
                    <h5>Cuadrante 4</h5>
                    <?php 
                        for($j=25; $j <= 32; $j++): // 8 imágenes para el cuadrante 4
                    ?>
                        <a href="" class="VectorD" valor="<?php echo $j; ?>">
                            <img src="{{ asset('img/cuadrante.jpeg') }}" width="70px" alt="cuadrante" class="vector">
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>

    <div id="odontogram">
        <!-- Ejemplo de diente -->
        <div class="tooth" data-id="1">
            <div class="vector top"></div>
            <div class="vector bottom"></div>
            <div class="vector left"></div>
            <div class="vector right"></div>
            <div class="vector center"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Manejar el click en los vectores
            $('.vector').on('click', function() {
                $(this).toggleClass('selected');
            });

            $('.VectorD').click(function() {
                let posicion = $(this).attr('valor');
                alert(posicion);
                return false;
            });
        });
    </script>
</body>
</html>
@endsection



