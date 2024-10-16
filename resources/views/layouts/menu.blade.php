<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dentalfilling</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ======= Styles ====== -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
 
    <!-- =============== Navigation ================ -->
    <div >
        <!-- Navbar -->
        <nav id="custom-navbar" class="navbar navbar-expand-lg fixed-top navbar-light  justify-content-between" style="padding: 0.5rem 1rem;"> <!-- Ajusta el padding aquí -->
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo.png') }}" width="300" height="70">
            </a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <div class="media align-items-center">
                <img src="{{ asset('img/logo1.png') }}" alt="Logo" width="40" height="40" class="rounded-circle">
            </div>
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Cerrar Sesión') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

        <!-- ========================= Sidebar ==================== -->
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                           <!-- <i class="bi bi-grid"></i>  Icono de menú -->
                        </span>
                        <span class="title"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/home') }}">
                        <span class="icon">
                            <i class="bi bi-house-door"></i> <!-- Icono de inicio -->
                        </span>
                        <span class="title">Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/create-user') }}">
                        <span class="icon">
                            <i class="bi bi-person-plus"></i> <!-- Icono de agregar usuarios -->
                        </span>
                        <span class="title">Agregar Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/manage-users') }}">
                        <span class="icon">
                            <i class="bi bi-people"></i> <!-- Icono de gestionar usuarios -->
                        </span>
                        <span class="title">Gestionar Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/especialidades') }}">
                        <span class="icon">
                            <i class="bi bi-journal-medical"></i> <!-- Icono de especialidades -->
                        </span>
                        <span class="title">Especialidades</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/patient') }}">
                        <span class="icon">
                            <i class="bi bi-person-lines-fill"></i> <!-- Icono de nuevo paciente -->
                        </span>
                        <span class="title">Nuevo Paciente</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/doctor') }}">
                        <span class="icon">
                            <i class="bi bi-person-badge"></i> <!-- Icono de nuevo médico -->
                        </span>
                        <span class="title">Nuevo Médico</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.odontograma.index') }}">
                        <span class="icon">
                            <i class="bi bi-clipboard-plus"></i> <!-- Icono de odontograma -->
                        </span>
                        <span class="title">Odontograma</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/consent') }}">
                        <span class="icon">
                            <i class="bi bi-file-earmark-text"></i> <!-- Icono de consentimiento informado -->
                        </span>
                        <span class="title">Consentimiento Informado</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/backup') }}">
                        <span class="icon">
                            <i class="bi bi-hdd"></i> <!-- Icono de respaldo -->
                        </span>
                        <span class="title">Respaldo</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <i class="bi bi-list"></i> <!-- Icono de menú de Bootstrap -->
                </div>
            </div>

            

            <!-- Main Content -->
            <main class="content py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="{{ asset('js/main.js') }}"></script>
    
</body>
</html>