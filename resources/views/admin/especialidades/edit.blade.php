@extends('layouts.menu')

@section('content')
<div class="container">
    <div id="app">


        <div class="content">
        <div id="title-wrapper" class="d-flex align-items-start">
            <a href="{{ url('/admin/especialidades') }}" id="icon-link" class="me-3">
                <div id="custom-icon-container">
                    <i class="bi bi-house-fill"></i>
                </div>
            </a>
            <div class="table-title">
                <h1>Editar Especialidades</h1>
            </div>
        </div>
        <div class="form-container">
            <form action="{{ route('admin.especialidades.update', $especialidad->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $especialidad->name) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                        <textarea name="description" class="form-control">{{ old('description', $especialidad->description) }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>    
        </div>
    </div>

</div>
@endsection
