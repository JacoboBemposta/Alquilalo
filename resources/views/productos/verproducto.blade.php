@extends('layouts.menu')

@section('contenido')


<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://www.sandbox.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency=EUR"></script>




<style>
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 50px;
    }

    /* Estilo para la imagen */
    .img-hover-zoom {
        transition: transform 0.3s ease;
        /* Transición suave para el zoom */
        cursor: pointer;
    }

    /* Efecto de zoom al pasar el ratón */
    .img-hover-zoom:hover {
        transform: scale(5);
        /* Amplía la imagen al 150% */
    }

    #paypal-button-container {
        display: none;
        /* Oculto por defecto */
        margin-top: 10px;
        /* Espacio entre el botón "Valorar Producto" y el botón de PayPal */
        width: 100%;
        /* Asegura que el div ocupe todo el ancho disponible */
        max-width: 400px;
        /* Limita el tamaño máximo a 400px */
        padding: 20px;
        /* Agrega algo de padding */
        background-color: white;
        /* Fondo blanco */
        border-radius: 8px;
        /* Bordes redondeados */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        /* Agrega sombra para darle profundidad */
        margin-left: auto;
        margin-right: auto;
        /* Centra el div horizontalmente */
    }
</style>
<div class="producto row text-center mt-5">
    <!-- Columnas imágenes -->
    <div class="row col-6">
        <!-- Columna de miniaturas de imágenes -->
        <div class="col-2"></div>
        <div class="col-2 d-flex flex-column" style="gap: 1px; height:40vh">
            @for ($i = 0; $i < 5; $i++)
                @if (isset($producto->imagenes[$i]))
                <img src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[$i]->nombre }}"
                    class="img-thumbnail img-miniatura"
                    style="cursor: pointer; flex: 1; margin-bottom: 1px; height:5vh;object-fit: contain"
                    onmouseover="cambiarImagen('{{ $producto->imagenes[$i]->nombre }}')">
                @else
                <div class="img-miniatura" style="flex: 1; margin-bottom: 2px; height:5vh; width:5vw">
                </div>
                @endif
                @endfor
        </div>

        <!-- Columna de imagen principal -->
        <div class="col-8 d-flex justify-content-center">
            <img src="{{ isset($producto->imagenes[0]) ? '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre : '/path/to/placeholder/image.jpg' }}"
                id="imagenPrincipal"
                class="img-fluid rounded"
                style="width: 40vw; height: 40vh; object-fit: contain;">
        </div>
    </div>

    <!-- Columna de precios y formulario de reserva -->
    <div class="col-6 mt-5">
        <div class="d-flex align-items-start">
            <!-- Precios del producto alineados a la izquierda -->
            <div class="col-4 text-start">
                <div>
                    <p><b>Precio por día:</b> {{ number_format($producto->precio_dia, 2) }} €</p>
                    <p><b>Precio por semana:</b> {{ number_format($producto->precio_semana, 2) }} €</p>
                    <p><b>Precio por mes:</b> {{ number_format($producto->precio_mes, 2) }} €</p>
                    @if ($producto->caracteristicas->descuento)
                    <p><b>Descuento:</b> {{ $producto->caracteristicas->descuento }}%</p>
                    @endif
                    <p><b>Fianza:</b> {{ $producto->fianza }}</p>
                </div>

                <div class="col-6 mt-5">
                    <div class="d-flex align-items-start">
                        <div class="col-8 text-center d-flex flex-column justify-content-center align-items-center">
                            <!-- Mostrar el botón solo si el usuario tiene un alquiler activo del producto -->
                            @if ($alquilerActivo)
                            <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#modalValoracion">
                                Valorar Producto
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario para seleccionar la fecha y reservar -->
            <div class="col-8 text-center d-flex flex-column justify-content-center align-items-center">
              @if(Auth::check() && Auth::id() !== $producto->usuario->id) <!-- Comprobamos si el usuario autenticado no es el propietario -->
                <form action="{{ route('productos.actualizarReserva', $producto) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" name="fecha_rango" id="fecha_rango" class="form-control" required placeholder="Selecciona la fecha" style="width:10vw">
                    </div>

                    <!-- Contenedor para mostrar el precio total -->
                    <div id="precioTotal" style="font-weight: bold; margin-bottom: 1rem;">Precio con seguro: 0.00 €</div>
                    <div id="precioconfianza" style="font-weight: bold; margin-bottom: 1rem;">Precio con fianza: 0.00 €</div>
                    <!-- Campo oculto para enviar el precio total calculado -->
                    <input type="hidden" name="precio_total" id="precio_total">
                    <input type="hidden" id="fianza" name="fianza" value="{{ $producto->fianza }}">
                    <button type="submit" class="btn btn-secondary" style="display: none;">Alquilalo</button>
                </form>
                <div class="mt-1">
                    <p>Valoraciones:</p>
                    <div class="rating" style="width:12vw;">
                        <input value="5" name="rate" id="star5" type="radio">
                        <label title="text" for="star5"></label>
                        <input value="4" name="rate" id="star4" type="radio">
                        <label title="text" for="star4"></label>
                        <input value="3" name="rate" id="star3" type="radio" checked="true">
                        <label title="text" for="star3"></label>
                        <input value="2" name="rate" id="star2" type="radio">
                        <label title="text" for="star2"></label>
                        <input value="1" name="rate" id="star1" type="radio">
                        <label title="text" for="star1"></label>
                    </div>
                </div>
                <p><b>Usuario: </b>{{ $producto->usuario->name }}</p>
                @endif
            </div>

        </div>
    </div>
</div>

<!-- BOTON PAYPAL -->

<div id="paypal-button-container" style="display: none;"></div>





<!-- Modal para valoración del producto -->
<div class="modal fade" id="modalValoracion" tabindex="-1" aria-labelledby="modalValoracionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalValoracionLabel">Valorar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('valoraciones.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_producto" value="{{ $producto->id }}">

                    <!-- Campo para puntuación -->
                    <div class="mb-3">
                        <label for="puntuacion" class="form-label">Puntuación</label>
                        <select class="form-select" name="puntuacion" id="puntuacion" required>
                            <option value="5">5 - Excelente</option>
                            <option value="4">4 - Muy Bueno</option>
                            <option value="3">3 - Bueno</option>
                            <option value="2">2 - Regular</option>
                            <option value="1">1 - Malo</option>
                        </select>
                    </div>

                    <!-- Campo para comentario -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Comentario</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Escribe tu comentario" required></textarea>
                    </div>

                    <!-- Campo para imagen -->
                    <div class="mb-3">
                        <label for="ruta_imagen" class="form-label">Subir Foto</label>
                        <input class="form-control" type="file" name="ruta_imagen" id="ruta_imagen" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar Valoración</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="col-12 p-5" style="font-size: 200%;">
    <p style="margin-left: 5vw;"><b>Descripción</b></p>
    <p style="font-size:0.5em;margin-left: 5vw;margin-right: 10vw;">{{ $producto->caracteristicas->descripcion }}</p>
</div>

</div>
<div class="container mt-5">

    <!-- Tu código existente de la vista -->

    <!-- Tabla de valoraciones -->
    @if ($valoraciones->isNotEmpty())
    <h2 class="mt-4 text-center mb-5">Valoraciones</h2>
    <table id="tablaValoraciones" class="display text-center" style="width:100%">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Comentario</th>
                <th>Usuario</th>
                <th>Puntuación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($valoraciones as $valoracion)
            <tr>
                <td>
                    @if ($valoracion->ruta_imagen)
                    <img src="{{ asset('storage/' . $valoracion->ruta_imagen) }}" alt="Imagen de la valoración"
                        class="img-thumbnail rounded img-hover-zoom" style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                    Sin imagen
                    @endif
                </td>
                <td>{{ $valoracion->descripcion }}</td>
                <td>{{ $valoracion->usuario->name }}</td>
                <td>{{ $valoracion->puntuacion }} / 5</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<script>
    $(document).ready(function() {
        $('#tablaValoraciones').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 de 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sPrevious": "Anterior",
                    "sNext": "Siguiente",
                    "sLast": "Último"
                }
            },
            "searching": false // Esto desactiva el campo de búsqueda
        });
    });


    // Función para cambiar la imagen principal cuando se hace clic en una miniatura
    function cambiarImagen(imagenNombre) {
        const imagenPrincipal = document.getElementById('imagenPrincipal');
        // Cambiar el src de la imagen principal al src de la miniatura seleccionada
        imagenPrincipal.src = `/storage/productos/{{ $producto->id }}` + '/' + imagenNombre;
    }


    // Obtener la valoración media del producto desde Laravel
    const valoracionMedia = @json($producto -> valoracion_media);

    // Seleccionar la estrella correspondiente según la valoración media
    document.addEventListener("DOMContentLoaded", function() {
        const ratingInput = document.querySelector(`input[name="rate"][value="${Math.round(valoracionMedia)}"]`);
        if (ratingInput) {
            ratingInput.checked = true; // Marcar la estrella
        }
    });

    const precioDia = @json($producto -> precio_dia);
    const precioSemana = @json($producto -> precio_semana);
    const precioMes = @json($producto -> precio_mes);
    const descuento = @json($producto -> caracteristicas -> descuento ?? 0);

    function calcularPrecioTotal(fechaInicio, fechaFin) {
        const diasReserva = Math.ceil((fechaFin - fechaInicio) / (1000 * 60 * 60 * 24)) + 1; // Días de reserva

        let precioTotal = 0;

        // Si la reserva es de menos de 7 días, se calcula con precio diario
        if (diasReserva < 7) {
            precioTotal = precioDia * diasReserva;
        }
        // Si la reserva es de entre 7 y 29 días, calcula en semanas completas más días adicionales
        else if (diasReserva < 30) {
            const semanasCompletas = Math.floor(diasReserva / 7);
            const diasAdicionales = diasReserva % 7;

            precioTotal = (precioSemana * semanasCompletas) + (precioDia * diasAdicionales);
        }
        // Si la reserva es de 30 días o más, calcula en meses completos, semanas completas y días adicionales
        else {
            const mesesCompletos = Math.floor(diasReserva / 30);
            const diasRestantes = diasReserva % 30;

            const semanasCompletas = Math.floor(diasRestantes / 7);
            const diasAdicionales = diasRestantes % 7;

            precioTotal = (precioMes * mesesCompletos) + (precioSemana * semanasCompletas) + (precioDia * diasAdicionales);
        }

        // Aplicar descuento si existe
        if (descuento > 0) {
            precioTotal -= precioTotal * (descuento / 100);
        }

        return precioTotal.toFixed(2); // Retornar con dos decimales
    }

    function actualizarPrecioTotal(selectedDates) {
        if (selectedDates.length === 2) { // Solo calcular si hay dos fechas
            const fechaInicio = selectedDates[0];
            const fechaFin = selectedDates[1];
            const precio = calcularPrecioTotal(fechaInicio, fechaFin); // Calcula el precio total como string
            const precioNum = parseFloat(precio); // Convierte el precio a número

            if (isNaN(precioNum)) {
                console.error("El precio calculado no es un número válido.");
            } else {
                const precioConSeguro = precioNum + (precioNum * 0.10); // Calcular el precio total con seguro
                const fianza = @json($producto -> fianza); // Obtener el valor de la fianza desde Laravel
                const precioConFianza = precioConSeguro + parseFloat(fianza); // Calcular precio total con fianza

                // Actualizar los divs con el precio calculado
                document.getElementById("precioTotal").textContent = `Precio con seguro: ${precioConSeguro.toFixed(2)} €`;
                document.getElementById("precioconfianza").textContent = `Precio con fianza: ${precioConFianza.toFixed(2)} €`;

                // Establecer el valor en el campo oculto para enviarlo en el formulario
                document.getElementById("precio_total").value = precioConSeguro.toFixed(2);

                // Mostrar el botón de PayPal solo cuando el precio total se haya calculado
                document.getElementById("paypal-button-container").style.display = "block";
                renderPaypalButton(precioConSeguro.toFixed(2), fianza); // Pasar el precio calculado y la fianza al botón de PayPal
            }
        }
    }


    // Función para renderizar el botón de PayPal con el precio calculado
    function renderPaypalButton(totalPrice, fianza) {
        paypal.Buttons({
        createOrder: function (data, actions) {
            let alquiler = totalPrice * 0.95; // Precio del alquiler (2 decimales)
            let fivePercent = (totalPrice * 0.05).toFixed(2); // Comisión (5%)
            let fianzaFixed = parseFloat(fianza).toFixed(2); // Fianza (2 decimales)


            // Calcular el subtotal total
            let subtotal = (parseFloat(alquiler) + parseFloat(fivePercent) + parseFloat(fianzaFixed)).toFixed(2);

        return actions.order.create({
            purchase_units: [{
                reference_id: 'default',
                amount: {
                    currency_code: "EUR",
                    value: subtotal, // Total del pago (2 decimales)
                    breakdown: {
                        item_total: {
                            value: subtotal, // Debe coincidir exactamente con la suma de los items
                            currency_code: "EUR"
                        }
                    }
                },
                items: [
                    {
                        name: "Precio del alquiler",
                        unit_amount: {
                            currency_code: "EUR",
                            value: alquiler // Precio base
                        },
                        quantity: "1"
                    },
                    {
                        name: "Comisión del 5%",
                        unit_amount: {
                            currency_code: "EUR",
                            value: fivePercent // Comisión
                        },
                        quantity: "1"
                    },
                    {
                        name: "Fianza",
                        unit_amount: {
                            currency_code: "EUR",
                            value: fianzaFixed // Fianza
                        },
                        quantity: "1"
                    }
                ],
                payee: {
                    email_address: 'sb-efu7q34194401@business.example.com' // Cuenta receptora
                }
            }]
        });
    },
    onApprove: function (data, actions) {
        return actions.order.capture().then(function (details) {
            // Recoger el ID de la transacción
            const transactionId = details.id; 
            realizarAlquiler(transactionId);
        });
    },
    onError: function (err) {
        console.error('Error en el pago', err);
        alert('Ocurrió un error al procesar el pago.');
    }
}).render('#paypal-button-container');


    }

    // Realiza el alquiler después de que el pago sea exitoso
    function realizarAlquiler(transactionId) {
        let fianza = document.getElementById('fianza').value;
        console.log(fianza);  // Verifica si el valor de fianza es correcto
        var formData = new FormData();
        formData.append('fecha_rango', document.getElementById('fecha_rango').value);
        formData.append('precio_total', document.getElementById('precio_total').value);
        formData.append('fianza', fianza);
        formData.append('transaction_id', transactionId); 
        formData.append('_token', '{{ csrf_token() }}');

        console.log('Datos enviados:', Object.fromEntries(formData.entries())); // Verifica los datos enviados al backend

        fetch("{{ route('productos.actualizarReserva', $producto) }}", {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Respuesta recibida:', response);
                return response.json();
            })
            .then(data => {
                console.log('Datos del backend:', data);
                if (data.success) {
                    alert("Alquiler realizado con éxito");
                    window.location.href = '{{ route("perfil") }}';
                } else {
                    alert("Error al realizar el alquiler: " + (data.error || "Intenta nuevamente."));
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                alert("Ocurrió un error al intentar realizar la reserva.");
            });
    }
    // Array con las fechas reservadas
    var fechasReservadas = @json($fechas_reservadas);

    // Inicializar Flatpickr para permitir la selección de un rango de fechas sin cerrar automáticamente
    flatpickr("#fecha_rango", {
        mode: "range", // Permite seleccionar un rango de fechas
        dateFormat: "Y-m-d", // Formato de fecha
        minDate: "today", // La fecha mínima seleccionable es hoy
        locale: "es", // Idioma en español
        disable: fechasReservadas, // Desactiva fechas reservadas
        closeOnSelect: false, // Evita que se cierre al seleccionar la primera fecha
        onChange: function(selectedDates, dateStr, instance) {
            // Si seleccionamos una sola fecha (inicio y fin son iguales)
            if (selectedDates.length === 1) {
                instance.setDate(selectedDates[0]);
                instance.open();
            }
            // Si ya se seleccionaron ambas fechas (un rango completo), cerramos el calendario
            if (selectedDates.length === 2) {
                instance.close();
            }
        },
        onClose: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                actualizarPrecioTotal(selectedDates); // Calcular y actualizar el precio total
            }
        },
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            if (fechasReservadas.includes(dStr)) {
                dayElem.style.backgroundColor = "#FF6347"; // Color rojo
                dayElem.style.color = "white";
            }
        }
    });





    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío automático del formulario
        if (document.getElementById("precio_total").value) {
            // Solo permitir el envío si el precio total ya ha sido calculado
            this.submit(); // Enviar el formulario una vez que el precio esté listo
        } else {
            alert('Por favor, selecciona un rango de fechas antes de proceder.');
        }
    });
</script>

@endsection