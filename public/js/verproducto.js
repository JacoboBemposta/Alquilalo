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
        const fianza = @json($producto->fianza); // Obtener el valor de la fianza desde Laravel
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
        createOrder: function(data, actions) {
            // Calcular el 5% del total
            let fivePercent = (totalPrice * 0.05).toFixed(2);

            return actions.order.create({
                purchase_units: [{
                    reference_id: 'default', // Asegúrate de que el ID sea único
                    amount: {
                        currency_code: "EUR",  // Asegúrate de especificar la moneda
                        value: (parseFloat(totalPrice) + parseFloat(fianza)), // Total del alquiler + fianza
                        breakdown: {
                            item_total: { 
                                value: (totalPrice * 0.95).toFixed(2), // 95% al cliente
                                currency_code: "EUR" // Agrega currency_code aquí también
                            },
                            shipping: { 
                                value: fivePercent, // 5% al cliente para la empresa
                                currency_code: "EUR" // Agrega currency_code aquí también
                            },
                            handling: {  // Añadir la fianza separada
                                value: fianza,  // Asegúrate de que la fianza tenga 2 decimales
                                currency_code: "EUR"
                            }
                        }
                    },
                    payee: {
                        email_address: 'sb-efu7q34194401@business.example.com' // El correo de la cuenta de la empresa para recibir el 5%
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {

                realizarAlquiler();

            });
        },
        onError: function(err) {
            console.error('Error en el pago', err);
            alert('Ocurrió un error al procesar el pago.');
        }
    }).render('#paypal-button-container'); // Renderiza el botón
}

// Realiza el alquiler después de que el pago sea exitoso
function realizarAlquiler() {
var formData = new FormData();
formData.append('fecha_rango', document.getElementById('fecha_rango').value);
formData.append('precio_total', document.getElementById('precio_total').value);
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
event.preventDefault();  // Prevenir el envío automático del formulario
if (document.getElementById("precio_total").value) {
    // Solo permitir el envío si el precio total ya ha sido calculado
    this.submit();  // Enviar el formulario una vez que el precio esté listo
} else {
    alert('Por favor, selecciona un rango de fechas antes de proceder.');
}
});




