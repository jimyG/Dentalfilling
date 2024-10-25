@extends('layouts.menu')

@section('content')
<div class="container">
        <div class="table-title">
            <h1>Editar Usuario</h1>
        </div>
    <div class="content">

    <form method="POST" action="{{ route('admin.updateUser', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required autocomplete="name">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required autocomplete="email">
        </div>

        <div class="form-group">
            <label for="password">Nueva Contraseña (Opcional)</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
        </div>

        <div class="form-group">
            <label for="role">Rol</label>
            <select class="form-control" id="role" name="role" required>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>



    </div>

</div>
@endsection
