@extends('layouts.menu')

@section('content')
<div class="container">
        <div id="title-wrapper" class="d-flex align-items-start">
            <a href="{{ url('/admin/manage-users') }}" id="icon-link" class="me-3">
                <div id="custom-icon-container">
                    <i class="bi bi-house-fill"></i>
                </div>
            </a>
            <div class="table-title">
                <h1>Crear Usuario</h1>
            </div>
        </div>

    <!-- Mostrar errores de validación -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Mostrar mensaje de éxito -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-container">
        <form method="POST" action="{{ route('admin.createUser') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa tu nombre completo" required 
                        pattern="[A-Za-zÀ-ÿ\s]+" title="El nombre solo debe contener letras y espacios.">
                </div>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Ingrese una Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Crea una contraseña" maxlength="8" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirma tu contraseña" maxlength="8" required>
                </div>
            </div>

            <div class="form-group">
                <label for="role">Rol</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                    <select class="form-control" id="role" name="role" required>
                        <option value="Administrador">Administrador</option>
                        <option value="Médico">Médico</option>
                        <option value="Paciente">Paciente</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>

</div>
@endsection
