@extends('layouts.menu')

@section('contenido')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="css/perfil.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }

    td,
    th {
        text-align: center;
        vertical-align: middle;
        padding: 10px;
    }

    .col-producto {
        width: 20%;
    }

    .col-fecha {
        width: 15%;
    }

    .col-precio {
        width: 10%;
        text-align: right;
    }

    .col-acciones {
        min-width: 150px;
        /* Espacio mínimo para evitar colapsos */
    }
</style>
<div class="container profile-container">
    <div class="profile-header mx-auto p-4">
        <h2>{{ Auth::user()->name }}</h2>
        <p>Email: {{ Auth::user()->email }}</p>
        <div class="change-password">
            <a href="{{ route('password.request') }}" class="btn btn-secondary">Cambiar Contraseña</a>
        </div>
    </div>

    <hr>


    <!-- Modal para mostrar detalles -->
    <div class="modal fade" id="modalDetallesPago" tabindex="-1" role="dialog" aria-labelledby="detallesPagoModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetallesPago">Detalles del Pago</h5>
                </div>
                <div class="modal-body" id="detallesPagoBody">
                    <p><strong>ID de Transacción:</strong> <span id="transactionId"></span></p>
                    <p><strong>Total:</strong> €<span id="total"></span></p>
                    <p><strong>Recibir:</strong> €<span id="recibir"></span></p>
                    <p><strong>Comisiones:</strong> €<span id="comisiones"></span></p>
                    <p><strong>Fecha Inicio:</strong> <span id="fecha_inicio"></span></p>
                    <p><strong>Fecha Fin:</strong> <span id="fecha_fin"></span></p>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para abrir incidencia -->
    <div class="modal fade" id="modalAbrirIncidencia" tabindex="-1" role="dialog" aria-labelledby="modalAbrirIncidenciaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAbrirIncidenciaLabel">Abrir Incidencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- El formulario ahora está recibiendo el alquiler_id -->
                    <form id="formIncidencia" action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Campo oculto para almacenar el alquiler_id -->
                        <input type="hidden" id="alquiler_id" name="alquiler_id">

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="foto">Adjuntar Foto</label>
                            <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*">
                        </div>

                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Abrir Incidencia</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <!-- Sección de Arrendatario -->
    <div class="rentals-section section">
        <h3>
            Alquileres Realizados como Arrendatario
            <button class="btn toggle-btn" data-target="#arrendatarioSection">
                <i class="fas fa-plus"></i>
            </button>
        </h3>
        <div id="arrendatarioSection" style="display: none;">
            @if($alquileresComoArrendatario->isNotEmpty())
            <table id="arrendatarioTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="col-producto">Producto</th>
                        <th class="col-fecha">Fecha Inicio</th>
                        <th class="col-fecha">Fecha Fin</th>
                        <th class="col-precio">Precio (€)</th>
                        <th class="col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $acumuladoArrendatario = 0; @endphp
                    @foreach($alquileresComoArrendatario as $alquiler)
                    @php
                    $incidencia = $alquiler->incidencia;
                    @endphp
                    <tr>
                        <td class="col-producto">{{ $alquiler->producto->nombre }}</td>
                        <td class="col-fecha">{{ $alquiler->fecha_inicio }}</td>
                        <td class="col-fecha">{{ $alquiler->fecha_fin }}</td>
                        <td class="col-precio">{{ $alquiler->precio_total }}</td>
                        <td class="col-acciones">
                            @php
                            $fecha_inicio = \Carbon\Carbon::parse($alquiler->fecha_inicio);
                            $fecha_fin = \Carbon\Carbon::parse($alquiler->fecha_fin);
                            $fecha_limite = \Carbon\Carbon::now()->addDays(2); // Dos días a partir de la fecha actual
                            $fecha_24h = \Carbon\Carbon::now()->subHours(24); // Hace 24 horas
                            @endphp

                            <div style="
                                display: grid; 
                                grid-template-columns: repeat(4, 40px); 
                                gap: 10px; 
                            ">
                                <!-- Botón de editar -->
                                @if($fecha_inicio->isFuture() && $fecha_inicio->gt($fecha_limite))
                                <div>
                                    <form action="{{ route('alquileres.edit', ['id' => $alquiler->id, 'id_producto' => $alquiler->id_producto]) }}" method="GET">
                                        <button type="submit" class="btn" title="Editar">
                                            <img src="{{ asset('imagenes/editar.jpeg') }}" alt="Editar" style="width: 25px; height: 25px;">
                                        </button>
                                    </form>
                                </div>
                                @else
                                <div></div> <!-- Espacio reservado -->
                                @endif

                                <!-- Botón de eliminar -->
                                @if($fecha_inicio->isFuture() && $fecha_inicio->gt($fecha_limite))
                                <div>
                                    <form action="{{ route('alquileres.cancel', $alquiler->id) }}" method="POST" onsubmit="return confirmDelete();">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn" title="Eliminar">
                                            <img src="{{ asset('imagenes/eliminar.jpeg') }}" alt="Eliminar" style="width: 25px; height: 25px;">
                                        </button>
                                    </form>
                                </div>
                                @else
                                <div></div> <!-- Espacio reservado -->
                                @endif

                                <!-- Botón de incidencia -->
                                @if($fecha_inicio->isPast() && $fecha_fin->gt($fecha_24h))
                                <div>
                                    @if(isset($incidencia) && !$incidencia->resuelta)

                                    <!-- Si existe la incidencia, mostrar la foto en miniatura -->
                                    <img src="{{ asset('imagenes/ticket.png') }}" title="Incidencia abierta" alt="Incidencia abierta" style="width: 25px; height: 25px; object-fit: cover;">
                                    @else
                                    <!-- Si no existe la incidencia, mostrar el botón para abrir una nueva incidencia -->
                                    <button class="btn btn-sm" title="Abrir incidencia" onclick="abrirIncidencia('{{ $alquiler->id }}')">
                                        <img src="{{ asset('imagenes/incidencia.png') }}" alt="Abrir incidencia" style="width: 25px; height: 25px;">
                                    </button>
                                    @endif
                                </div>
                                @else
                                <div>
                                    @if(isset($incidencia) && !$incidencia->resuelta)
                                    <!-- Si existe la incidencia, mostrar la foto en miniatura -->
                                    <img src="{{ asset('imagenes/ticket.png') }}" title="Incidencia abierta" alt="Incidencia abierta" style="width: 25px; height: 25px; object-fit: cover;">
                                    @endif
                                </div>
                                @endif

                                <!-- Botón de detalles -->
                                @if(!empty($alquiler->transaction_id))
                                <div>
                                    <button class="btn btn-sm" title="Ver detalles del pago" onclick="mostrarDetalles('{{ $alquiler->transaction_id }}')">
                                        <img src="{{ asset('imagenes/vermas.jpg') }}" alt="Ver Alquileres" style="width: 25px; height: 25px;">
                                    </button>
                                </div>
                                @else
                                <div></div> <!-- Espacio reservado -->
                                @endif
                            </div>
                        </td>



                        @php $acumuladoArrendatario += $alquiler->precio_total; @endphp
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Total acumulado como arrendatario:</strong> {{ $acumuladoArrendatario }} €</p>
            @else
            <p>No has realizado ningún alquiler como arrendatario.</p>
            @endif
        </div>
    </div>

    <br>
    <hr>
    <br>

    <!-- Sección de Arrendador -->
    <div class="rentals-section section">
        <h3>
            Alquileres Realizados como Arrendador
            <button class="btn toggle-btn" data-target="#arrendadorSection">
                <i class="fas fa-plus"></i>
            </button>
        </h3>
        <div id="arrendadorSection" style="display: none;">
            @php $acumuladoArrendador = 0; @endphp
            @if($alquileresComoArrendador->isNotEmpty())
            <table id="arrendadorTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="col-producto">Producto</th>
                        <th class="col-fecha">Fecha Inicio</th>
                        <th class="col-fecha">Fecha Fin</th>
                        <th class="col-precio">Precio (€)</th>
                        <th class="col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $acumuladoArrendador = 0; @endphp
                    @foreach($alquileresComoArrendador as $alquiler)
                    @php
                    $incidencia = $alquiler->incidencia;
                    @endphp

                    <tr>
                        <td class="col-producto">{{ $alquiler->producto->nombre }}</td>
                        <td class="col-fecha">{{ $alquiler->fecha_inicio }}</td>
                        <td class="col-fecha">{{ $alquiler->fecha_fin }}</td>
                        <td class="col-precio">{{ $alquiler->precio_total }}</td>
                        <td class="col-acciones">
                            @php
                            $fecha_inicio = \Carbon\Carbon::parse($alquiler->fecha_inicio);
                            $fecha_fin = \Carbon\Carbon::parse($alquiler->fecha_fin);

                            // Fecha límite: 24 horas después de la fecha de fin del alquiler
                            $fechaLimite = $fecha_fin->copy()->addHours(48);

                            // Asegúrate de que la fecha actual esté en el rango correcto
                            $hoy = \Carbon\Carbon::now();
                            @endphp

                            <div style="
                                display: grid; 
                                grid-template-columns: repeat(4, 40px); 
                                gap: 10px; 
                            ">
                                <!-- Botón de incidencia -->
                                @if($hoy->gte($fecha_fin) && $hoy->lte($fechaLimite))
                                {{-- Si la fecha actual está dentro del rango, mostrar el icono de incidencia --}}
                                @if(isset($incidencia) && !$incidencia->resuelta)
                                <!-- Mostrar el icono de incidencia abierta si la incidencia no está resuelta -->
                                <img src="{{ asset('imagenes/ticket.png') }}"
                                    title="Incidencia abierta"
                                    alt="Incidencia"
                                    style="width: 25px; height: 25px; object-fit: cover;">
                                @else
                                <!-- Si la incidencia está resuelta o no existe, mostrar el botón para abrir incidencia -->
                                <button class="btn btn-sm"
                                    title="Abrir incidencia"
                                    onclick="abrirIncidencia('{{ $alquiler->id }}')">
                                    <img src="{{ asset('imagenes/incidencia.png') }}"
                                        alt="Abrir incidencia"
                                        style="width: 25px; height: 25px;">
                                </button>
                                @endif
                                @else
                                <!-- Placeholder vacío o lo que quieras mostrar cuando no está dentro del rango -->
                                <div style="width: 25px; height: 25px;">
                                    @if(isset($incidencia) && !$incidencia->resuelta)
                                    <!-- Si existe la incidencia y no está resuelta, mostrar el icono de incidencia -->
                                    <img src="{{ asset('imagenes/ticket.png') }}" title="Incidencia abierta" alt="Incidencia abierta" style="width: 25px; height: 25px; object-fit: cover;">
                                    @endif
                                </div>
                                @endif

                                <!-- Botón de detalles -->
                                @if(!empty($alquiler->transaction_id))
                                <button class="btn btn-sm"
                                    title="Ver detalles del pago"
                                    onclick="mostrarDetalles('{{ $alquiler->transaction_id }}')">
                                    <img src="{{ asset('imagenes/vermas.jpg') }}"
                                        alt="Ver Alquileres"
                                        style="width: 25px; height: 25px;">
                                </button>
                                @else
                                <!-- Placeholder vacío -->
                                <div style="width: 25px; height: 25px;"></div>
                                @endif
                            </div>
                        </td>


                        @php $acumuladoArrendador += $alquiler->precio_total; @endphp
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <p><strong>Total acumulado como arrendador:</strong> {{ $acumuladoArrendador }} €</p>
            @else
            <p>No has realizado ningún alquiler como arrendador.</p>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializa las tablas de DataTables
        $('#arrendatarioTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/Spanish.json"
            }
        });
        $('#arrendadorTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/Spanish.json"
            }
        });

        // Alternar el contenido y el icono al hacer clic en el botón
        $('.toggle-btn').on('click', function() {
            var target = $(this).data('target');
            var icon = $(this).find('i');

            // Alterna la visibilidad del contenido
            $(target).toggle();

            // Cambia el icono entre '-' y '+'.
            if ($(target).is(':visible')) {
                icon.removeClass('fa-plus').addClass('fa-minus');
            } else {
                icon.removeClass('fa-minus').addClass('fa-plus');
            }
        });
    });

    // Esta función se ejecuta cuando el usuario hace clic en el botón de ver detalles
    function mostrarDetalles(transaction_id) {
        // Hacer una solicitud AJAX para obtener los detalles de la transacción
        $.ajax({
            url: '/pagos/detalles/' + transaction_id, // URL con el transaction_id
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    $('#transactionId').text(response.data.transaction_id);
                    $('#total').text(response.data.Total);
                    $('#recibir').text(response.data.Recibir);
                    $('#comisiones').text(response.data.Comisiones);
                    $('#fecha_inicio').text(response.data.fecha_inicio);
                    $('#fecha_fin').text(response.data.fecha_fin);

                    // Muestra el modal
                    $('#modalDetallesPago').modal('show');
                } else {
                    alert('No se pudo obtener los detalles del pago');
                }
            },
            error: function() {
                alert('Error al obtener los detalles del pago');
            }
        });
    }

    function abrirIncidencia(alquilerId) {
        console.log(alquilerId); // Revisa que alquilerId tenga un valor correcto
        if (alquilerId) {
            // Establece el alquiler_id en el formulario
            $('#alquiler_id').val(alquilerId);

            // Muestra el modal
            $('#modalAbrirIncidencia').modal('show');
        } else {
            console.error("El alquilerId es inválido.");
        }
    }
</script>

@endsection