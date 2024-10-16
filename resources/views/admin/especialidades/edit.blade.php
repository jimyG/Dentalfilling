@extends('layouts.menu')

@section('content')
<div class="container">
    <div id="app">


        <div class="content">
            <h1>Editar Especialidad</h1>

    <form action="{{ route('admin.especialidades.update', $especialidad->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $especialidad->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control">{{ old('description', $especialidad->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
        </div>
    </div>

</div>
@endsection
