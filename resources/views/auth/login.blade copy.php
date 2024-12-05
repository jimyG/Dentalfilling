<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dental Filling</title>

    <!--Bootstrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Personalización-->
    <link rel="stylesheet" type="text/css" href="asset/styles.css">

    <!-- Estilo para la imagen de fondo -->
    <style>
        body {
            background-image: url('img/fondo2.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
    </style>
</head>
<body>
    <!-- Navbar con el logo -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #f2eff7;">
        <div class="container">
            <a class="navbar-brand" href="#" style="display: flex; align-items: center;">
                <img src="img/logo.png" alt="Logo" style="width: 200px; height: auto;">
            </a>
            <div class="navbar-text mx-auto" style="color: #351663; font-size: 1.5rem;">
                BIENVENIDO A DENTAL FILLING
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3 style="text-align: center;">Inicio de sesión</h3>
                    <div class="d-flex justify-content-end social_icon">
                        <a href="https://www.facebook.com/p/Dental-Filling-100089769878604/?locale=ca_ES" target="_blank">
                            <span><i class="fab fa-facebook-square"></i></span>
                        </a>
                        <a href="https://wa.me/+50376561004" target="_blank">
                            <span><i class="fab fa-whatsapp" style="color: #25D366;"></i></span> <!-- Color de WhatsApp -->
    </a>
                    </div>

                </div>
                <div class="card-body">
                    <!-- Aquí comienza el formulario de Laravel -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Campo de Correo Electrónico -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo Electrónico">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Campo de Contraseña -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Recordar Usuario -->
                        <div class="row align-items-center remember">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Recordar usuario</label>
                        </div>

                        <!-- Botón de Login -->
                        <div class="form-group">
                            <input type="submit" value="Iniciar Sesión" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        ¿Olvidaste tu Contraseña? <a href="#"></a>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('password.request') }}">Recuperar Contraseña</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
// Obtener el año actual
$year = date("Y");
?>
<footer>
    <p>&copy; <?php echo $year; ?> Todos los derechos reservados.</p>
</footer>
</html>