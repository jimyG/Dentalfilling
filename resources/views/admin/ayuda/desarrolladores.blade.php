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

    </style>

</head>

<body >
<div class="areaa container" >
        <ul class="circles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
        </ul>
        
    <div class="table-title">
        <h1>Desarrolladores</h1>
    </div>

    <div class="slick-slider">
        <div class="card">
            <img src="{{ asset('img/card/avatar-2.png') }}" alt="Desarrollador 1">
            <h3 class="name-icon">Jimy Ronal Soriano Garcia</h3>
            <div class="content-card">
                
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

</div >
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

</body>



@endsection
