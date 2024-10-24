@extends('layouts.menu')

@section('content')
<div class="container">
        <div class="table-title">
            <h1>Crear Nueva Especialidad</h1>
        </div>
        <div class="form-container">
            <form action="{{ route('admin.especialidades.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre de la Especialidad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa el nombre de la especialidad" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción de la Especialidad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Ingresa una descripción para la especialidad" required></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Especialidad</button>
            </form>
        </div>

    
</div>
@endsection
