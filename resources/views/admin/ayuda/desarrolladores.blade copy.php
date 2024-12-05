@extends('layouts.menu')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/card.css') }}">
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Slick JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <style>
        
            .card {
                    background-color: #f9f9f9; /* Color de fondo */
                    border-radius: 10px;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                    text-align: center;
                    padding: 20px;
                    margin: 10px;
                    display: flex; 
                    flex-direction: column; 
                    align-items: center; 
                    transition: transform 0.3s; /* Efecto de transición */
                }
                .card:hover {
                    transform: scale(1.05); /* Efecto zoom */
                }
                
                .card img { 
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin-bottom: 15px;
            display: block; /* Asegurarse de que sea un bloque */
            margin-left: auto; /* Ajustes de margen para centrar */
            margin-right: auto; /* Ajustes de margen para centrar */
            border: 4px solid #3498db; /* Cambia el color y el grosor del contorno según tus preferencias */
        }
            .card h3 {
                font-size: 20px;
                margin: 10px 0;
            }
            .card p {
                color: #666;
                font-size: 14px;
            }
            .card button {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 5px;
                cursor: pointer;
                margin-top: 10px;
            }
            .card button:hover {
                background-color: #0056b3;
            }
            .content-card {
    display: flex;
    flex-direction: column;
    align-items: flex-start; /* Alinea el contenido a la izquierda */
}

            /* Icono personalizado antes de cada etiqueta con color específico */
.name-icon::before {
    content: "👤"; /* Icono para el nombre */
    color: #28a745; /* Verde */
    margin-right: 8px;
}

.role-icon::before {
    content: "💼"; /* Icono para el rol */
    color: #ffa500; /* Naranja */
    margin-right: 8px;
}

.experience-icon::before {
    content: "⏳"; /* Icono para la experiencia */
    color: #007bff; /* Azul */
    margin-right: 8px;
}

.languages-icon::before {
    content: "💻"; /* Icono para lenguajes */
    color: #d8a4eb; /* Lila */
    margin-right: 8px;
}
</style>

</head>

<body >
<div class="container  padding: 20px; border-radius: 10px; height: calc(100vh - 40px); margin: 20px 0;">
    <div class="table-title">
        <h1>Desarrolladores</h1>
    </div>

    <div class="slick-slider">
        <div class="card">
            <img src="{{ asset('img/card/avatar-2.png') }}" alt="Desarrollador 1">
            <div class="content-card">
                <h3 class="name-icon">Jimy Ronal Soriano Garcia</h3>
                <p class="role-icon">Rol: Backend Developer</p>
                <p class="experience-icon">Experiencia: 4 años</p>
                <p class="languages-icon">Lenguajes: PHP, Laravel, MySQL</p>
            </div>
        </div>
        <div class="card">
        <img src="{{ asset('img/card/avatar-2.png') }}" alt="Desarrollador 2">
            <h3 class="name-icon">Marlon Ernesto Fernández Obispo </h3>
            <div class="content-card">
                <p class="role-icon">Rol: Frontend Developer</p>
                <p class="experience-icon">Experiencia: 3 años</p>
                <p class="languages-icon">Lenguajes: HTML, CSS, JavaScript</p>
            </div>
        </div>
        <div class="card">
            <img src="{{ asset('img/card/avatar-3.png') }}" alt="Diseñador 1">
            <h3 class="name-icon">Ana Cecilia Martínez Valladares</h3>
            <div class="content-card">
                <p class="role-icon">Rol: UI/UX Designer</p>
                <p class="experience-icon">Experiencia: 4 años</p>
                <p class="languages-icon">Herramientas: Figma, Sketch</p>
            </div>    
        </div>
        <div class="card">
        <img src="{{ asset('img/card/avatar-3.png') }}" alt="Diseñador 2">
            <h3 class="name-icon">María Estela Jorge Martínez  </h3>
            <div class="content-card">
                <p class="role-icon">Rol: UI/UX Designer</p>
                <p class="experience-icon">Experiencia: 4 años</p>
                <p class="languages-icon">Herramientas: Figma, Sketch</p>
            </div>    
        </div>
        <div class="card">
        <img src="{{ asset('img/card/avatar-2.png') }}" alt="Desarrollador 2">
            <h3 class="name-icon">Henrry Geovanny Castañeda Cáceres</h3>
            <div class="content-card">
                <p class="role-icon">Rol: Backend Developer</p>
                <p class="experience-icon">Experiencia: 6 años</p>
                <p class="languages-icon">Lenguajes: JavaScript, Python, Php, my SQL</p>
            </div>    
        </div>
    </div>
</div>  
</body>



<script type="text/javascript">
$(document).ready(function(){
    $('.slick-slider').slick({
        slidesToShow: 3, // Muestra 3 tarjetas
        slidesToScroll: 1,
        dots: true, // Muestra los puntos de navegación
        infinite: true, // Carrusel infinito
        autoplay: true, // Autoplay
        autoplaySpeed: 2000, // Velocidad de autoplay
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1, // Muestra 1 tarjeta en pantallas pequeñas
                    slidesToScroll: 1
                }
            }
        ]
    });
});
</script>

@endsection
