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
                <h1>Editar Medico</h1>
            </div>
        </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.doctor.update', $medico->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $medico->name) }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $medico->email) }}">
        </div>

        <div class="form-group">
            <label for="especialidad_id" class="form-label">Especialidad</label>
            <select name="especialidad_id" id="especialidad_id" class="form-control">
                <option value="">Selecciona una especialidad</option>
                @foreach($especialidades as $especialidad)
                    <option value="{{ $especialidad->id }}" {{ old('especialidad_id', $medico->especialidad_id) == $especialidad->id ? 'selected' : '' }}>
                        {{ $especialidad->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="sexo_id" class="form-label">Sexo</label>
            <select name="sexo_id" id="sexo_id" class="form-control">
                <option value="">Selecciona un sexo</option>
                @foreach($sexos as $sexo)
                    <option value="{{ $sexo->id }}" {{ old('sexo_id', $medico->sexo_id) == $sexo->id ? 'selected' : '' }}>
                        {{ $sexo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="mb-3">
            <label for="dui" class="form-label">DUI</label>
            <input type="text" class="form-control" id="dui" name="dui" value="{{ old('dui', $medico->dui) }}">
        </div>

        <div class="mb-3">
            <label for="edad" class="form-label">Edad</label>
            <input type="number" class="form-control" id="edad" name="edad" value="{{ old('edad', $medico->edad) }}">
        </div>

        <div class="mb-3">
            <label for="LicenseNumber" class="form-label">Número de Licencia</label>
            <input type="text" class="form-control" id="LicenseNumber" name="LicenseNumber" value="{{ old('LicenseNumber', $medico->LicenseNumber) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $medico->address) }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $medico->phone) }}">
        </div>

        <button type="submit" class="btn btn-warning">Actualizar Médico</button>
    </form>
</div>
@endsection
