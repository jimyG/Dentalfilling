@extends('layouts.menu')

@section('content')
        <head>
            
        


        </head>

        <div class="container  padding: 20px; border-radius: 10px; height: calc(100vh - 40px); margin: 20px 0;">
            <div class="table-title">
                <h1>Más recursos</h1>
            </div>


            <div class="more-options">
           <!-- Verifica si el usuario tiene permiso para ver el PDF del administrador -->
                    <!-- Tarjeta para PDF administrador-->
                <!-- Tarjeta para PDF usuario -->
                <div class="card-custom card-pdf-usuario">
                    <i class="bi bi-file-earmark-pdf icon-custom"></i>
                    <h5>PDF Usuario</h5>
                    <br>
                    <button class="button-hover" onclick="window.location.href='{{ route('admin.ayuda.descargar.pdf', ['tipo' => 'usuario']) }}'">Descargar</button>
                </div>
                    <div class="card-custom card-pdf-administrador">
                        <i class="bi bi-file-earmark-pdf icon-custom"></i>
                        <h5>PDF Administrador</h5>
                        <br>
                        <button class="button-hover" onclick="window.location.href='{{ route('admin.ayuda.descargar.pdf', ['tipo' => 'administrador']) }}'">Descargar</button>
                    </div>

                    <!-- Tarjeta para Videos -->
                    <div class="card-custom card-videos">
                        <i class="bi bi-youtube icon-custom"></i>
                        <h5>Video</h5>
                        <br>
                        <button class="button-hover" onclick="window.open('https://www.youtube.com/watch?v=oRG76Tjh5Ns', '_blank')">Ir</button>
                    </div>
                

                <!-- Tarjeta para Desarrolladores -->
                <div class="card-custom card-desarrolladores">
                    <i class="bi bi-person-gear icon-custom"></i>
                    <h5>Desarrolladores</h5>
                    <br>
                    <button class="button-hover" onclick="window.location.href='{{ route('admin.ayuda.desarrolladores') }}'">Ir</button>
                </div>

                <!-- Tarjeta para Guia Rapida -->
                <div class="card-custom card-videos">
                    <i class="bi bi-journal-text icon-custom"></i>
                    <h5>Guia Rapida</h5>
                    <br>
                    <button class="button-hover" onclick="window.open('https://www.youtube.com/watch?v=oRG76Tjh5Ns', '_blank')">Ir</button>
                </div>

                <!-- Tarjeta para Videos -->
                <div class="card-custom card-videos">
                    <i class="bi bi-film icon-custom"></i>
                    <h5>Videos</h5>
                    <br>
                    <<button class="button-hover" onclick="window.open('https://www.youtube.com/watch?v=oRG76Tjh5Ns', '_blank')">Ir</button>
                </div>
            </div>

        </div>

@endsection
