@extends('layouts.menu')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="form-odontograma">
    <form action="{{ route('admin.odontograma.store') }}" method="POST" id="odontogramaForm" class="odontograma-form">
        @csrf
        <div class="table-title">
            <h1>Odontograma</h1>
        </div>

        <div class="select-odontograma" style="display: flex; justify-content: center; align-items: center; gap: 20px;">
            <!-- Selección de paciente -->
            <div class="select-container paciente">
                <label for="paciente">
                    <div class="icon-container">
                        <i class="bi bi-person" aria-hidden="true"></i> <!-- Ícono de paciente -->
                    </div>
                    Paciente:
                </label>
                <select name="paciente_id" id="paciente" required class="form-select">
                    <option value="">Seleccione un paciente</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}">{{ $paciente->nombres }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Selección de tratamiento -->
            <div class="select-container tratamiento">
                <label for="tratamiento">
                    <div class="icon-container">
                    <i class="bi bi-plus-circle" aria-hidden="true"></i> <!-- Ícono de tratamiento: medicina -->
                    </div>
                    Tratamiento:
                </label>
                <select name="tratamiento_id" id="tratamiento" required class="form-select">
                    <option value="">Seleccione un tratamiento</option>
                    @foreach($tratamientos as $tratamiento)
                        <option value="{{ $tratamiento->id }}" style="background-color: {{ $tratamiento->color }}">
                            {{ $tratamiento->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Odontograma -->
        <div class="odontograma">
                <div class="cuadrante" id="cuadrante1">
                    <h3>Cuadrante 1 </h3>
                    <div class="dientes">
                        @for ($i = 1; $i <= 8; $i++)
                            <div class="diente" data-diente="{{ $i }}">
                                <div class="numero-diente">{{ $i }}</div>
                                <div class="area" data-area="superior">U</div>
                                <div class="area" data-area="izquierda">I</div>
                                <div class="area" data-area="centro">C</div>
                                <div class="area" data-area="derecha">D</div>
                                <div class="area" data-area="inferior">L</div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="cuadrante" id="cuadrante2">
                    <h3>Cuadrante 2</h3>
                    <div class="dientes">
                        @for ($i = 9; $i <= 16; $i++)
                            <div class="diente" data-diente="{{ $i }}">
                                <div class="numero-diente">{{ $i }}</div>
                                <div class="area" data-area="superior">U</div>
                                <div class="area" data-area="izquierda">I</div>
                                <div class="area" data-area="centro">C</div>
                                <div class="area" data-area="derecha">D</div>
                                <div class="area" data-area="inferior">L</div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="cuadrante" id="cuadrante3">
                    <h3>Cuadrante 3</h3>
                    <div class="dientes">
                        @for ($i = 17; $i <= 24; $i++)
                            <div class="diente" data-diente="{{ $i }}">
                                <div class="numero-diente">{{ $i }}</div>
                                <div class="area" data-area="superior">U</div>
                                <div class="area" data-area="izquierda">I</div>
                                <div class="area" data-area="centro">C</div>
                                <div class="area" data-area="derecha">D</div>
                                <div class="area" data-area="inferior">L</div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="cuadrante" id="cuadrante4">
                    <h3>Cuadrante 4</h3>
                    <div class="dientes">
                        @for ($i = 25; $i <= 32; $i++)
                            <div class="diente" data-diente="{{ $i }}">
                                <div class="numero-diente">{{ $i }}</div>
                                <div class="area" data-area="superior">U</div>
                                <div class="area" data-area="izquierda">I</div>
                                <div class="area" data-area="centro">C</div>
                                <div class="area" data-area="derecha">D</div>
                                <div class="area" data-area="inferior">L</div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Botón para guardar -->
            <button type="submit" style="margin-top: 20px;">Guardar</button>
            </form>
        </div>



<script>
    
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



@endsection
