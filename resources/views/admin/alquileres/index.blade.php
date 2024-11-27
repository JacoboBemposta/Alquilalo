@extends('layouts.menu')

@section('contenido')
<style>
    .table-container {
        display: flex;
        justify-content: center;
        width: 100%; /* Abarca todo el ancho del contenedor */
        padding: 20px; /* Espaciado alrededor */
    }
    .table-wrapper {
        width: 90%; /* Ancho ajustable de la tabla */
        max-width: 1400px; /* Máximo ancho para pantallas grandes */
    }
    .btn img {
        width: 20px;
        height: 20px;
    }
</style>

@if(auth()->user()->is_admin == true)

<div class="text-center">
    <h1 class="mb-4">Alquileres</h1>
</div>
<div class="d-flex justify-content-center">
    <table id="tablaAlquileres" class="table table-bordered " style="width: 80vw">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Arrendatario</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alquileres as $alquiler)
                <tr>
                    <td>{{ $alquiler->id }}</td>
                    <td>{{ $alquiler->producto->nombre }}</td>
                    <td>{{ $alquiler->arrendatario->name }}</td>
                    <td>{{ $alquiler->fecha_inicio }}</td>
                    <td>{{ $alquiler->fecha_fin }}</td>
                    <td>
                        @php
                            $ultimoRegistro = $alquiler->entregasRecogidas->first();
                        @endphp
                        {{ $ultimoRegistro ? $ultimoRegistro->estado : 'Sin Estado' }}
                    </td>
                    <td>
                    <a href="{{ route('admin.detalles_alquiler', $alquiler->id) }}" class="btn btn-sm toggle-alquileres">
                            <img src="{{ asset('imagenes/vermas.jpg') }}" alt="Ver Alquileres" title="Ver alquileres">
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center">
    <h1>No tienes permisos para ver esta sección</h1>
</div>
@endif




<script>
    $(document).ready(function() {
        const table = $('#tablaAlquileres').DataTable({
            info: false, // Oculta el contador de resultados (info)
            ordering: true, // Permite ordenar las columnas
            paging: false, // Desactiva la paginación
            language: {
                url: '/proxy/spanish'
            },
            order: [[3, 'asc']] // Ordena inicialmente por la columna "Inicio" (índice 3) en orden descendente
        });
    });
</script>
@endsection
