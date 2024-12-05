@extends('layouts.menu')

@section('content')
    <div class="container">
        <div class="table-title">
            <h1>Respaldo del Sistema</h1>
        </div>

        <div class="alert alert-info mt-3">
            Puedes generar una copia de respaldo de la base de datos de tu sistema.
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('admin.backup.generar') }}" class="btn btn-primary">
                <i class="bi bi-hdd"></i> Generar Respaldo
            </a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
    </div>
@endsection
