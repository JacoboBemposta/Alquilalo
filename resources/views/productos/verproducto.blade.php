@extends('layouts.menu')

@section('contenido')


<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
                </div>
            </div>
            <!-- Formulario para seleccionar la fecha y reservar -->
            <div class="col-8 text-center d-flex flex-column justify-content-center align-items-center">
                <form action="{{ route('productos.actualizarReserva', $producto) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" name="fecha_rango" id="fecha_rango" class="form-control" required placeholder="Selecciona la fecha" style="width:10vw">
                    </div>

                    <!-- Contenedor para mostrar el precio total -->
                    <div id="precioTotal" style="font-weight: bold; margin-bottom: 1rem;">Precio Total: 0.00 €</div>

                    <!-- Campo oculto para enviar el precio total calculado -->
                    <input type="hidden" name="precio_total" id="precio_total">

                    <button type="submit" class="btn btn-secondary">Alquilalo</button>
                </form>
                <div class="mt-1">
                    <p>Valoraciones:</p>
                    <div class="rating" style="width:12vw;">
                        <input value="5" name="rate" id="star5" type="radio">
                        <label title="text" for="star5"></label>
                        <input value="4" name="rate" id="star4" type="radio">
                        <label title="text" for="star4"></label>
                        <input value="3" name="rate" id="star3" type="radio" checked="">
                        <label title="text" for="star3"></label>
                        <input value="2" name="rate" id="star2" type="radio">
                        <label title="text" for="star2"></label>
                        <input value="1" name="rate" id="star1" type="radio">
                        <label title="text" for="star1"></label>
                    </div>
                </div>
                <p><b>Usuario: </b>{{ $producto->usuario->name }}</p>
            </div>
        </div>
    </div>
</div>

<div class="col-12 p-5" style="font-size: 200%;">
    <p style="margin-left: 5vw;"><b>Descripción</b></p>
    <p style="font-size:0.5em;margin-left: 5vw;margin-right: 10vw;">{{ $producto->caracteristicas->descripcion }}</p>
</div>

</div>

<script>
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

    // Función para calcular el precio total
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


    // Actualizar el precio cuando se selecciona un rango de fechas
    function actualizarPrecioTotal(selectedDates) {
        if (selectedDates.length === 2) { // Solo calcular si hay dos fechas
            const fechaInicio = selectedDates[0];
            const fechaFin = selectedDates[1];
            const precioTotal = calcularPrecioTotal(fechaInicio, fechaFin);

            // Mostrar el precio calculado en el div de precioTotal
            document.getElementById("precioTotal").textContent = `Precio Total: ${precioTotal} €`;

            // Establecer el valor en el campo oculto para enviarlo en el formulario
            document.getElementById("precio_total").value = precioTotal;
        }
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
</script>





@endsection