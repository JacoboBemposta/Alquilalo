@extends('layouts.menu')

@section('contenido')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="css/perfil.css">

<div class="container profile-container">
    <div class="profile-header">
        <h2>{{ Auth::user()->name }}</h2>
        <p>Email: {{ Auth::user()->email }}</p>
        <div class="change-password">
            <a href="{{ route('password.request') }}" class="btn btn-secondary">Cambiar Contraseña</a>
        </div>
    </div>

    <hr>

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
                        <th>Producto</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Precio (€)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $acumuladoArrendatario = 0; @endphp
                    @foreach($alquileresComoArrendatario as $alquiler)
                    <tr>
                        <td>{{ $alquiler->producto->nombre }}</td>
                        <td>{{ $alquiler->fecha_inicio }}</td>
                        <td>{{ $alquiler->fecha_fin }}</td>
                        <td>{{ $alquiler->precio_total }}</td>
                        <td>
                            @php
                            $fecha_inicio = \Carbon\Carbon::parse($alquiler->fecha_inicio);
                            $fecha_limite = \Carbon\Carbon::now()->addDays(2); // Dos días a partir de la fecha actual
                            @endphp

                            <!-- Condición para mostrar los botones de editar y eliminar solo si la fecha de inicio es futura y mayor que la fecha límite -->
                            @if($fecha_inicio->isFuture() && $fecha_inicio->gt($fecha_limite))
                            <div style="display: flex; align-items: center;">
                                <!-- Botón de editar -->
                                <form action="{{ route('alquileres.edit', ['id' => $alquiler->id, 'id_producto' => $alquiler->id_producto]) }}" method="GET" >
                                    <button type="submit" class="btn" title="Editar">
                                        <img src="{{ asset('imagenes/editar.jpeg') }}" alt="Editar" style="width: 25px; height: 25px;">
                                    </button>
                                </form>

                                <!-- Botón de eliminar -->
                                <form action="{{ route('alquileres.cancel', $alquiler->id) }}" method="POST" onsubmit="return confirmDelete();">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn" title="Eliminar">
                                        <img src="{{ asset('imagenes/eliminar.jpeg') }}" alt="Eliminar" style="width: 25px; height: 25px;">
                                    </button>
                                </form>
                            </div>
                            @endif
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
                        <th>Productos</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Precio (€)</th>

                    </tr>
                </thead>
                <tbody>
                    @php $acumuladoArrendador = 0; @endphp
                    @foreach($alquileresComoArrendador as $alquiler)
                    <tr>
                        <td>{{ $alquiler->producto->descripcion }}</td>
                        <td>{{ $alquiler->fecha_inicio }}</td>
                        <td>{{ $alquiler->fecha_fin }}</td>
                        <td>{{ $alquiler->precio_total }}</td>
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

            // Cambia el icono entre '-' y '+'
            if ($(target).is(':visible')) {
                icon.removeClass('fa-plus').addClass('fa-minus');
            } else {
                icon.removeClass('fa-minus').addClass('fa-plus');
            }
        });
    });
</script>

@endsection