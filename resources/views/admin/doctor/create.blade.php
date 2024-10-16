@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Nuevo Médico</h2>

    <!-- Mostrar la alerta de éxito si el médico fue creado -->
    @if (session('success'))
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <!-- Verificar si hay errores y mostrar los mensajes -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('admin.doctor.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Médico</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="especialidad_id" class="form-label">Especialidad</label>
            <select name="especialidad_id" id="especialidad_id" class="form-control" required>
                <option value="">Selecciona una especialidad</option>
                @foreach($especialidades as $especialidad)
                    <option value="{{ $especialidad->id }}" {{ old('especialidad_id') == $especialidad->id ? 'selected' : '' }}>
                        {{ $especialidad->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="sexo_id" class="form-label">Sexo</label>
            <select name="sexo_id" id="sexo_id" class="form-control" required>
                <option value="">Selecciona un sexo</option>
                @foreach($sexos as $sexo)
                    <option value="{{ $sexo->id }}" {{ old('sexo_id') == $sexo->id ? 'selected' : '' }}>
                        {{ $sexo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="mb-3">
            <label for="dui" class="form-label">DUI</label>
            <input type="text" class="form-control" id="dui" name="dui" value="{{ old('dui') }}" required>
        </div>

        <div class="mb-3">
            <label for="edad" class="form-label">Edad</label>
            <input type="number" class="form-control" id="edad" name="edad" value="{{ old('edad') }}" required>
        </div>

        <div class="mb-3">
            <label for="LicenseNumber" class="form-label">Número de Licencia</label>
            <input type="text" class="form-control" id="LicenseNumber" name="LicenseNumber" value="{{ old('LicenseNumber') }}" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Médico</button>
    </form>
</div>

<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
