@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Nueva Especialidad</h2>

    <form action="{{ route('admin.especialidades.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre de la Especialidad</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción de la Especialidad</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Especialidad</button>
    </form>
</div>
@endsection
