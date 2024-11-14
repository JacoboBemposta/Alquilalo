@extends('layouts.menu')

@section('contenido')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4" style="max-width: 600px; width: 100%; border-radius: 10px;">
        <h2 class="text-center mb-4">Editar Alquiler</h2>

        <!-- Mostrar los mensajes de éxito o error -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Formulario de edición del alquiler -->
        <form action="{{ route('alquileres.update', $alquiler->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Usamos PUT ya que estamos actualizando -->

            <!-- Datos del alquiler -->
            <div class="form-group">
                <label for="producto">Producto</label>
                <input type="text" class="form-control" id="producto" value="{{ $alquiler->producto->nombre }}" disabled>
            </div>

            <!-- Rango de Fechas -->
            <div class="form-group">
                <label for="fecha_rango">Rango de Fechas</label>
                <input type="text" id="fecha_rango" class="form-control" value="{{ \Carbon\Carbon::parse($alquiler->fecha_inicio)->format('Y-m-d') }} a {{ \Carbon\Carbon::parse($alquiler->fecha_fin)->format('Y-m-d') }}" readonly>
                <!-- Campos ocultos para enviar las fechas -->
                <input type="hidden" name="fecha_inicio" id="fecha_inicio" value="{{ $alquiler->fecha_inicio }}">
                <input type="hidden" name="fecha_fin" id="fecha_fin" value="{{ $alquiler->fecha_fin }}">
            </div>

            <!-- Precio Total -->
            <div class="form-group">
                <label for="precio_total">Precio Total (€)</label>
                <div id="precioTotal" class="form-control-plaintext">{{ $alquiler->precio_total }} €</div>
                <input type="hidden" name="precio_total" id="precio_total" value="{{ $alquiler->precio_total }}">
            </div>

            <div style="width: 100%">
                <div class="d-flex justify-content-center gap-3"> <!-- Utilizando gap para separar los botones -->
                    <!-- Botón de actualizar -->
                    <button type="submit" class="btn btn-primary">Actualizar</button>

                    <!-- Botón de cancelar (volver a la vista anterior) -->
                    <a href="{{ route('perfil') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    const precioDia = @json($producto -> precio_dia);
    const precioSemana = @json($producto -> precio_semana);
    const precioMes = @json($producto -> precio_mes);
    const descuento = @json($producto -> caracteristicas -> descuento ?? 0);

    // Inicialización de flatpickr
    const fechaRangoPicker = flatpickr("#fecha_rango", {
        mode: "range", // Modo de selección de rango de fechas
        dateFormat: "Y-m-d", // Formato de fecha
        defaultDate: [
            "{{ \Carbon\Carbon::parse($alquiler->fecha_inicio)->format('Y-m-d') }}",
            "{{ \Carbon\Carbon::parse($alquiler->fecha_fin)->format('Y-m-d') }}"
        ], // Fecha por defecto para el rango
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                // Si hay un rango de fechas seleccionado, actualizamos el campo de texto
                document.getElementById("fecha_rango").value = selectedDates[0].toLocaleDateString() + " a " + selectedDates[1].toLocaleDateString();

                // Establecer las fechas en los campos ocultos
                document.getElementById("fecha_inicio").value = selectedDates[0].toLocaleDateString('en-CA'); // 'en-CA' para formato 'YYYY-MM-DD'
                document.getElementById("fecha_fin").value = selectedDates[1].toLocaleDateString('en-CA'); // 'en-CA' para formato 'YYYY-MM-DD'

                // Recalcular el precio total
                actualizarPrecioTotal(selectedDates);
            }
        }
    });

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

    // Función para actualizar el precio total en el formulario
    function actualizarPrecioTotal(selectedDates) {
        if (selectedDates.length === 2) {
            const fechaInicio = selectedDates[0];
            const fechaFin = selectedDates[1];

            // Verificar que ambas fechas sean válidas
            if (!isNaN(fechaInicio) && !isNaN(fechaFin) && fechaInicio < fechaFin) {
                const precioTotal = calcularPrecioTotal(fechaInicio, fechaFin);
                // Mostrar el precio calculado en el campo de solo lectura
                document.getElementById("precio_total").value = precioTotal;
                document.getElementById("precioTotal").textContent = precioTotal + " €"; // Actualizamos el campo visual
            }
        }
    }

    // Llamar a la función de actualización del precio al cargar la página para asegurarnos de que el valor se calcule correctamente
    window.onload = function() {
        const selectedDates = fechaRangoPicker.selectedDates;
        if (selectedDates.length === 2) {
            actualizarPrecioTotal(selectedDates);
        }
    }
</script>
@endsection