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
                <h1>Editar Usuario</h1>
            </div>
        </div>
    <div class="content">
    <div class="form-container">
    <form method="POST" action="{{ route('admin.updateUser', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required autocomplete="name">
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required autocomplete="email">
            </div>    
        </div>

        <div class="form-group">
            <label for="password">Nueva Contraseña (Opcional)</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" maxlength="8">
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password" maxlength="8">
            </div>
        </div>

        <div class="form-group">
            <label for="role">Rol</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                <select class="form-control" id="role" name="role" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>    
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
    </div>
    



    </div>

</div>
@endsection
