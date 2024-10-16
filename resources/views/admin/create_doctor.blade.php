@extends('layouts.menu')

@section('content')

<div class="container">
    <h2>Nuevo Médico</h2>
    <form action="{{ route('admin.doctor.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="especialidad_id">Especialidad</label>
            <select name="especialidad_id" class="form-control" required>
                <option value="">Selecciona una especialidad</option>
                @foreach($especialidades as $especialidad)
                    <option value="{{ $especialidad->id }}">{{ $especialidad->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="sexo_id">Sexo</label>
            <select name="sexo_id" class="form-control" required>
                <option value="">Selecciona un sexo</option>
                @foreach($sexos as $sexo)
                    <option value="{{ $sexo->id }}">{{ $sexo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="dui">DUI</label>
            <input type="text" name="dui" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="edad">Edad</label>
            <input type="number" name="edad" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="LicenseNumber">Número de Licencia</label>
            <input type="text" name="LicenseNumber" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="address">Dirección</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone">Teléfono</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear Médico</button>
    </form>
</div>

@endsection
