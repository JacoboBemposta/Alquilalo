
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