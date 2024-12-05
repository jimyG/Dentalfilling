@extends('layouts.menu')

@section('content')

<head>
    <!-- Otros enlaces de CSS/JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
    .folder-icon {
    display: inline-block;
    transition: transform 0.2s;
}

.folder-icon:hover {
    transform: scale(1.1);
}

#consultaForm {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>


@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}', // Muestra el primer error
        });
    </script>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<div class="form-odontograma">
    <form action="{{ route('admin.odontograma.store') }}" method="POST" id="odontogramaForm" class="odontograma-form">
        @csrf
        
        <div id="title-wrapper" class="d-flex align-items-start">
            <a href="{{ route('admin.odontograma.index') }}" id="icon-link" class="me-3">
                <div id="custom-icon-container">
                    <i class="bi bi-house-fill"></i>
                </div>
            </a>
            <div class="table-title">
                <h1>Odontograma</h1>
            </div>
        </div>
    

        <div class="select-odontograma" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 20px; max-width: 100%; padding: 20px;">
            <!-- Buscador de paciente -->
            <div class="select-container paciente" style="flex: 1; min-width: 280px; position: relative;">
                <label for="paciente-buscar" style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                    <div class="icon-container">
                        <i class="bi bi-person" aria-hidden="true"></i> <!-- Ícono de paciente -->
                    </div>
                    Buscar Paciente:
                </label>
                <input type="text" id="paciente-buscar" class="form-control" placeholder="Buscar paciente" style="width: 100%; max-width: 100%;">
                <input type="hidden" name="paciente_id" id="paciente_id"> <!-- Para guardar el id seleccionado -->
                
                <ul id="paciente-lista" class="dropdown-menu" style="display: none; position: absolute; z-index: 1000; max-height: 200px; overflow-y: auto; width: 100%;"></ul>
            </div>

            <!-- Selección de tratamiento -->
            <div class="select-container tratamiento" style="flex: 1; min-width: 280px;">
                <label for="tratamiento" style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                    <div class="icon-container">
                        <i class="bi bi-plus-circle" aria-hidden="true"></i> <!-- Ícono de tratamiento: medicina -->
                    </div>
                    Hallazgos Clinicos:
                </label>
                <select name="tratamiento_id" id="tratamiento" required class="form-select" style="width: 100%;">
                    <option value="">Seleccione un tratamiento</option>
                    @foreach($tratamientos as $tratamiento)
                        <option value="{{ $tratamiento->id }}" style="background-color: {{ $tratamiento->color }};">
                            {{ $tratamiento->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>


        <!-- Odontograma -->
        <div class="odontograma">
            <div class="cuadrante" id="cuadrante1">
                <h3>Cuadrante I</h3>
                <div class="dientes">
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="diente" data-diente="{{ $i }}">

                            <div class="area {{ $i >= 4 ? 'area-diferente' : '' }}" data-area="superior">V</div>
                            <div class="area {{ $i >= 4 ? 'area-diferente' : '' }}" data-area="izquierda">D</div>
                            <div class="area {{ $i >= 4 ? 'area-diferente' : '' }}" data-area="centro">O</div>
                            <div class="area {{ $i >= 4 ? 'area-diferente' : '' }}" data-area="derecha">M</div>
                            <div class="area {{ $i >= 4 ? 'area-diferente' : '' }}" data-area="inferior">L</div>
                        </div>
                    @endfor
                    @for ($i = 6; $i <= 8; $i++)
                        <div class="diente" data-diente="{{ $i }}">

                            <div class="area {{ $i >= 4 ? 'area-diferente' : '' }}" data-area="superior">V</div>
                            <div class="area {{ $i >= 4 ? 'area-diferente' : '' }}" data-area="izquierda">D</div>
                            <div class="area {{ $i >= 4 ? 'area-diferente' : '' }}" data-area="centro">I</div>
                            <div class="area {{ $i >= 4 ? 'area-diferente' : '' }}" data-area="derecha">M</div>
                            <div class="area {{ $i >= 4 ? 'area-diferente' : '' }}" data-area="inferior">L</div>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="cuadrante" id="cuadrante2">
                <h3>Cuadrante II</h3>
                <div class="dientes">
                    @for ($i = 9; $i <= 11; $i++)
                        <div class="diente" data-diente="{{ $i }}">

                            <div class="area {{ $i >= 9 && $i <= 13 ? 'area-diferente' : '' }}" data-area="superior">V</div>
                            <div class="area {{ $i >= 9 && $i <= 13 ? 'area-diferente' : '' }}" data-area="izquierda">M</div>
                            <div class="area {{ $i >= 9 && $i <= 13 ? 'area-diferente' : '' }}" data-area="centro">I</div>
                            <div class="area {{ $i >= 9 && $i <= 13 ? 'area-diferente' : '' }}" data-area="derecha">D</div>
                            <div class="area {{ $i >= 9 && $i <= 13 ? 'area-diferente' : '' }}" data-area="inferior">L</div>
                        </div>
                    @endfor

                    @for ($i = 12; $i <= 16; $i++)
                        <div class="diente" data-diente="{{ $i }}">

                            <div class="area {{ $i >= 9 && $i <= 13 ? 'area-diferente' : '' }}" data-area="superior">V</div>
                            <div class="area {{ $i >= 9 && $i <= 13 ? 'area-diferente' : '' }}" data-area="izquierda">M</div>
                            <div class="area {{ $i >= 9 && $i <= 13 ? 'area-diferente' : '' }}" data-area="centro">O</div>
                            <div class="area {{ $i >= 9 && $i <= 13 ? 'area-diferente' : '' }}" data-area="derecha">D</div>
                            <div class="area {{ $i >= 9 && $i <= 13 ? 'area-diferente' : '' }}" data-area="inferior">L</div>
                        </div>
                    @endfor
                </div>
            </div>


            <div class="cuadrante" id="cuadrante3">
                <h3>Cuadrante IV</h3>
                <div class="dientes">
                    @for ($i = 25; $i <= 29; $i++)
                        <div class="diente" data-diente="{{ $i }}">

                            <div class="area {{ $i >= 28 && $i <= 32 ? 'area-diferente' : '' }}" data-area="superior">V</div>
                            <div class="area {{ $i >= 28 && $i <= 32 ? 'area-diferente' : '' }}" data-area="izquierda">D</div>
                            <div class="area {{ $i >= 28 && $i <= 32 ? 'area-diferente' : '' }}" data-area="centro">O</div>
                            <div class="area {{ $i >= 28 && $i <= 32 ? 'area-diferente' : '' }}" data-area="derecha">M</div>
                            <div class="area {{ $i >= 28 && $i <= 32 ? 'area-diferente' : '' }}" data-area="inferior">L</div>
                        </div>
                    @endfor

                    @for ($i = 30; $i <= 32; $i++)
                        <div class="diente" data-diente="{{ $i }}">

                            <div class="area {{ $i >= 28 && $i <= 32 ? 'area-diferente' : '' }}" data-area="superior">V</div>
                            <div class="area {{ $i >= 28 && $i <= 32 ? 'area-diferente' : '' }}" data-area="izquierda">D</div>
                            <div class="area {{ $i >= 28 && $i <= 32 ? 'area-diferente' : '' }}" data-area="centro">I</div>
                            <div class="area {{ $i >= 28 && $i <= 32 ? 'area-diferente' : '' }}" data-area="derecha">M</div>
                            <div class="area {{ $i >= 28 && $i <= 32 ? 'area-diferente' : '' }}" data-area="inferior">L</div>
                        </div>
                    @endfor
                </div>
            </div>


        <div class="cuadrante" id="cuadrante4">
            <h3>Cuadrante III</h3>
            <div class="dientes">
                @for ($i = 17; $i <= 19; $i++)
                <div class="diente" data-diente="{{ $i }}">

                    <div class="area {{ $i >= 17 && $i <= 21 ? 'area-diferente' : '' }}" data-area="superior">V</div>
                    <div class="area {{ $i >= 17 && $i <= 21 ? 'area-diferente' : '' }}" data-area="izquierda">M</div>
                    <div class="area {{ $i >= 17 && $i <= 21 ? 'area-diferente' : '' }}" data-area="centro">I</div>
                    <div class="area {{ $i >= 17 && $i <= 21 ? 'area-diferente' : '' }}" data-area="derecha">D</div>
                    <div class="area {{ $i >= 17 && $i <= 21 ? 'area-diferente' : '' }}" data-area="inferior">L</div>
                </div>
            @endfor

            @for ($i = 20; $i <= 24; $i++)
                <div class="diente" data-diente="{{ $i }}">

                    <div class="area {{ $i >= 17 && $i <= 21 ? 'area-diferente' : '' }}" data-area="superior">V</div>
                    <div class="area {{ $i >= 17 && $i <= 21 ? 'area-diferente' : '' }}" data-area="izquierda">M</div>
                    <div class="area {{ $i >= 17 && $i <= 21 ? 'area-diferente' : '' }}" data-area="centro">O</div>
                    <div class="area {{ $i >= 17 && $i <= 21 ? 'area-diferente' : '' }}" data-area="derecha">D</div>
                    <div class="area {{ $i >= 17 && $i <= 21 ? 'area-diferente' : '' }}" data-area="inferior">L</div>
                </div>
            @endfor
            </div>
        </div>

            </div>

           <!-- Botón para mostrar u ocultar el formulario -->
           <button onclick="toggleForm()" class="btn btn-primary bi bi-heart-pulse-fill mt-3">
                Nueva Consulta
            </button>


            <!-- Contenedor del Formulario (inicialmente oculto) -->
            <div id="consultaForm" style="display: none; margin-top: 20px; background: #f7f7f7; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

            <div class="form-row mb-3">
                    <!-- Presión Arterial -->
                    <div class="col-md-4">
                        <label for="presion_arterial" class="form-label">
                            <i class="bi bi-heart-pulse-fill color-icon-consulta"></i> Presión Arterial
                        </label>
                        <input type="text" id="presion_arterial" name="presion_arterial" class="form-control" placeholder="Ej. 120/80" 
                            oninput="formatPresionArterial(this)">
                    </div>

                    <!-- Pulso -->
                    <div class="col-md-4">
                        <label for="pulso" class="form-label">
                            <i class="bi bi-heart color-icon-consulta"></i> Pulso
                        </label>
                        <input type="text" id="pulso" name="pulso" class="form-control" placeholder="Ej. 75 bpm" 
                            oninput="addBpm(this)">
                    </div>

                    <!-- Temperatura -->
                    <div class="col-md-4">
                        <label for="temperatura" class="form-label">
                            <i class="bi bi-thermometer-half color-icon-consulta"></i> Temperatura
                        </label>
                        <input type="text" id="temperatura" name="temperatura" class="form-control" placeholder="Ej. 37°C" 
                            oninput="addCelsius(this)">
                    </div>
                </div>

                    <div class="form-group">
                        <label for="motivo_consulta">Motivo de la Consulta</label>
                        <textarea name="motivo_consulta" id="motivo_consulta" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tratamiento_dental_id">Tratamiento a Realizar (si lo requiere)</label>
                        <select name="tratamiento_dental_id" id="tratamiento_dental_id" class="form-control">
                            <option value="">Selecciona un tratamiento</option>
                            @foreach ($tratamientos_dentales as $tratamiento)
                                <option value="{{ $tratamiento->id }}">{{ $tratamiento->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="diagnostico">Diagnóstico</label>
                        <textarea name="diagnostico" id="diagnostico" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tratamiento_propuesto">Tratamiento Propuesto</label>
                        <textarea name="tratamiento_propuesto" id="tratamiento_propuesto" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" rows="3"></textarea>
                    </div>

                    
            </div>



            <!-- Botón para guardar -->
            <button type="submit" class="btn btn-success  mt-3">Guardar</button>
            </form>
        </div>

<script>
    // Formatea la presión arterial en el formato "sistólica/diastólica"
    function formatPresionArterial(input) {
        let value = input.value.replace(/[^0-9/]/g, ''); // Elimina cualquier carácter que no sea dígito o '/'
        if (value.includes('/')) {
            const [sistolica, diastolica] = value.split('/');
            input.value = `${sistolica}/${diastolica}`;
        } else {
            input.value = value;
        }
    }

    // Agrega "bpm" automáticamente para el pulso
    function addBpm(input) {
        input.value = input.value.replace(/[^0-9]/g, '') + " bpm";
    }

    // Agrega "°C" automáticamente para la temperatura
    function addCelsius(input) {
        input.value = input.value.replace(/[^0-9.]/g, '') + "°C";
    }
</script>



<script>
    // Resto del código de JavaScript

    // Función para limpiar el odontograma
    function limpiarOdontograma() {
        // Restaurar el color de todas las áreas a su estado original
        document.querySelectorAll('.area').forEach(area => {
            area.style.backgroundColor = ''; // Quitar el color aplicado
        });

        // Eliminar todos los inputs ocultos generados
        document.querySelectorAll('input[type="hidden"]').forEach(input => {
            input.remove();
        });

        // Restablecer la selección de tratamiento
        document.getElementById('tratamiento').selectedIndex = 0;
        console.log("Odontograma limpiado");
    }

    document.querySelectorAll('.area').forEach(area => {
        area.addEventListener('click', function() {
            let tratamiento_id = document.getElementById('tratamiento').value;
            if (!tratamiento_id) {
                alert('Por favor, seleccione un tratamiento.');
                return;
            }

            // Cambiar el color del área seleccionada
            let tratamiento_color = document.querySelector('#tratamiento option[value="' + tratamiento_id + '"]').style.backgroundColor;
            this.style.backgroundColor = tratamiento_color;

            let diente = this.parentElement.getAttribute('data-diente');
            let areaNombre = this.getAttribute('data-area');

            // Añadir un input oculto para el diente y el área seleccionada
            const inputField = document.createElement('input');
            inputField.type = 'hidden';
            inputField.name = `dientes[${diente}][${areaNombre}]`;
            inputField.value = tratamiento_id;

            // Si ya existe el input oculto, lo actualizamos
            const existingInput = document.querySelector(`input[name="dientes[${diente}][${areaNombre}]"]`);
            if (existingInput) {
                existingInput.value = tratamiento_id; // Actualiza el valor si ya existe
            } else {
                document.getElementById('odontogramaForm').appendChild(inputField); // Añade el nuevo input al formulario
            }

            // Depuración para confirmar la creación y actualización de inputs
            console.log(`Input añadido: ${inputField.name} = ${inputField.value}`);
        });
    });

    // Verificar todos los inputs al enviar el formulario
    document.getElementById('odontogramaForm').addEventListener('submit', function(event) {
        const allInputs = document.querySelectorAll('input[type="hidden"]');
        console.log('Inputs antes de enviar:', allInputs);

        // Si necesitas una alerta de confirmación antes de enviar, puedes incluirla aquí
    });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.getElementById('paciente-buscar').addEventListener('input', function() {
    let query = this.value;

    if (query.length > 0) {
        fetch(`/buscar-pacientes?query=${query}`)
            .then(response => response.json())
            .then(data => {
                let lista = document.getElementById('paciente-lista');
                lista.innerHTML = ''; // Limpia la lista previa
                lista.style.display = 'block';

                // Itera sobre los resultados y los agrega a la lista
                data.forEach(paciente => {
                    let item = document.createElement('li');
                    item.classList.add('dropdown-item');
                    item.textContent = `${paciente.nombres} ${paciente.apellidos}`;
                    item.style.cursor = 'pointer';
                    item.onclick = function() {
                        document.getElementById('paciente-buscar').value = item.textContent;
                        document.getElementById('paciente_id').value = paciente.id;
                        lista.style.display = 'none';
                    };
                    lista.appendChild(item);
                });
            })
            .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('paciente-lista').style.display = 'none';
    }
});

// Ocultar el dropdown si se hace clic fuera
document.addEventListener('click', function(event) {
    let lista = document.getElementById('paciente-lista');
    if (!lista.contains(event.target) && event.target.id !== 'paciente-buscar') {
        lista.style.display = 'none';
    }
});

</script>


<script>
    function toggleForm() {
    const formContainer = document.getElementById('consultaForm');
    if (formContainer.style.display === 'none' || formContainer.style.display === '') {
        formContainer.style.display = 'block';
    } else {
        formContainer.style.display = 'none';
    }
}

</script>

@endsection
