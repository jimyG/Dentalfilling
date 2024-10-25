@extends('layouts.menu')

@section('content')
<div class="container">
        
        <div id="title-wrapper" class="d-flex align-items-start">
            <a href="{{ url('/admin/doctor') }}" id="icon-link" class="me-3">
                <div id="custom-icon-container">
                    <i class="bi bi-house-fill"></i>
                </div>
            </a>
            <div class="table-title">
                <h1>Crear Nuevo Medico</h1>
            </div>
        </div>
    

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
        <div class="form-container">
            <form action="{{ route('admin.doctor.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del Médico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Ingresa el nombre del médico" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Ingresa el email del médico" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="especialidad_id" class="form-label">Especialidad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                        <select name="especialidad_id" id="especialidad_id" class="form-control" required>
                            <option value="">Selecciona una especialidad</option>
                            @foreach($especialidades as $especialidad)
                                <option value="{{ $especialidad->id }}" {{ old('especialidad_id') == $especialidad->id ? 'selected' : '' }}>
                                    {{ $especialidad->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sexo_id" class="form-label">Sexo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                        <select name="sexo_id" id="sexo_id" class="form-control" required>
                            <option value="">Selecciona un sexo</option>
                            @foreach($sexos as $sexo)
                                <option value="{{ $sexo->id }}" {{ old('sexo_id') == $sexo->id ? 'selected' : '' }}>
                                    {{ $sexo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña (8 Dígitos)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" maxlength="8" placeholder="Crea una contraseña" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña (8 Dígitos)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" maxlength="8" placeholder="Confirma tu contraseña" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="dui" class="form-label">DUI</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <input type="text" class="form-control" id="dui" name="dui" maxlength="10" pattern="\d{8}-\d{1}" 
                        oninput="formatDui(this)" value="{{ old('dui') }}" placeholder="Ingresa el DUI (ej. 12345678-9)" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="edad" class="form-label">Edad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        <input type="number" class="form-control" id="edad" name="edad" value="{{ old('edad') }}" placeholder="Ingresa la edad" required min="0" max="99" maxlength="2">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="LicenseNumber" class="form-label">Número de Licencia</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                        <input type="text" class="form-control" id="LicenseNumber" name="LicenseNumber" maxlength="4" pattern="[0-9]{4}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);" value="{{ old('LicenseNumber') }}" placeholder="Ingresa el número de licencia (4 dígitos)" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Dirección</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-house"></i></span>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Ingresa la dirección" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" class="form-control" id="phone" name="phone" maxlength="8" pattern="[0-9]{8}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);"  value="{{ old('phone') }}" placeholder="Ingresa el teléfono (8 dígitos)" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Médico</button>
            </form>
        </div>
</div>

<script>
    function formatDui(input) {
        let value = input.value.replace(/\D/g, ''); // Eliminar todo lo que no sea un número
        if (value.length > 7) {
            value = value.slice(0, 8) + '-' + value.slice(8); // Insertar el guion antes del último dígito
        }
        input.value = value.slice(0, 10); // Limitar a 10 caracteres (8 dígitos + 1 guion + 1 dígito)
    }
</script>

<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
