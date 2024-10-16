
        $(document).ready(function() {
            let selectedSurfaces = {}; // { 11: {1: 'red', 2: 'green', ...}, 12: {...}, ... }
            let selectedColor = '';
            let currentToothId = null; // Para almacenar el ID del diente actualmente seleccionado

            // Selección de color
            $('.color-box').on('click', function() {
                $('.color-box').removeClass('selected'); // Limpiar selección previa
                $(this).addClass('selected'); // Marcar color seleccionado
                selectedColor = $(this).data('color'); // Guardar el color seleccionado
            });

            // Selección del diente
            $('.tooth').on('click', function() {
                currentToothId = $(this).data('tooth-id'); // Obtener ID del diente seleccionado

                // Llamada AJAX para obtener las superficies
                $.ajax({
                    url: `/tooth-surfaces/${currentToothId}`, // Cambia la ruta si es necesario
                    type: 'GET',
                    success: function(response) {
                        const surfaces = response.surfaces;

                        // Actualizar UI según las superficies obtenidas
                        $('.image-section').removeClass('selected').css('border', 'none'); 

                        // Aplicar colores a las secciones basados en los datos obtenidos
                        $.each(surfaces, function(sectionId, color) {
                            $(`.image-section[data-section="${sectionId}"]`).addClass('selected').css('border', `2px solid ${color}`);
                        });
                    },
                    error: function(xhr) {
                        alert('Error al obtener datos del diente.');
                    }
                });

                selectedSurfaces[currentToothId] = selectedSurfaces[currentToothId] || {}; // Inicializar objeto si no existe
                $('.image-section').removeClass('selected'); // Limpiar selección previa de secciones
                $('.image-section').css('border', 'none'); // Limpiar bordes de secciones
                console.log(`Diente seleccionado: ${currentToothId}`);
            });

            // Selección de parte de la imagen
            $('.image-section').on('click', function() {
                if (currentToothId === null) {
                    alert('Por favor, selecciona un diente primero.'); // Verificar si un diente ha sido seleccionado
                    return;
                }

                let sectionId = $(this).data('section');

                // Alternar selección de la sección
                if (selectedSurfaces[currentToothId][sectionId]) {
                    delete selectedSurfaces[currentToothId][sectionId]; // Desmarcar
                    $(this).removeClass('selected'); // Desmarcar sección
                    $(this).css('border', 'none'); // Limpiar el borde
                } else {
                    selectedSurfaces[currentToothId][sectionId] = selectedColor; // Guardar color seleccionado
                    $(this).addClass('selected'); // Marcar sección como seleccionada
                    $(this).css('border', `2px solid ${selectedColor}`); // Aplicar color al borde
                }

                console.log(selectedSurfaces); // Verificar en la consola
            });

            // Guardar datos al servidor para el diente actualmente seleccionado
            $('#saveButton').on('click', function() {
                if (currentToothId === null) {
                    alert('Por favor, selecciona un diente primero.'); // Verificar si un diente ha sido seleccionado
                    return;
                }

                $.ajax({
                    url: '{{ route("tooth-surfaces.store") }}', // Cambiar a la ruta correcta
                    type: 'POST',
                    data: {
                        tooth_id: currentToothId,
                        surfaces: selectedSurfaces[currentToothId] || {},
                        _token: '{{ csrf_token() }}' // Token de CSRF
                    },
                    success: function(response) {
                        alert('Datos guardados correctamente.');
                    },
                    error: function(xhr) {
                        alert('Error al guardar los datos.');
                    }
                });
            });
        });
