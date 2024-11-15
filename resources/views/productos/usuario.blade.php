@extends('layouts.menu')

@section('contenido')



<style>
    /* Ajustes de botón */
    .btn img {
        width: 20px;
        height: 20px;
    }

    /* Estilos generales para centrar contenido */
    th,
    td {
        padding: 10px;
        text-align: center;
        vertical-align: middle;
    }

    /* Ajustes específicos para la columna "Acumulado" */
    .acumulado {
        width: 10vw;
        /* Ajustar ancho según necesidad */
    }

    /* Flex para centrar el contenido en la columna acumulado */
    .acumulado-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        /* Espacio entre importe y botón */
    }
</style>

<div class="row justify-content-center">
    <div class="col-8">
        @if($productosDelUsuario->isEmpty())
        <p>No tienes ningún producto registrado</p>
        @else
        <table id="example" class="display text-center" style="width:100%">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th class="acumulado">Ganancias</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productosDelUsuario as $producto)
                <tr data-producto-id="{{ $producto->id }}">
                    <td>
                        <a href="{{ route('productos.verproducto', $producto) }}">
                            <img src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre }}" class="img-fluid rounded mx-auto d-block" style="max-width: 10vw; height: 10vh;">
                        </a>
                    </td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td class="acumulado">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Mostrar el total de alquileres desde el array $totales_alquiler -->
                            <span>{{ $totales_alquiler[$producto->id] ?? 0 }} €</span>
                            @if(($totales_alquiler[$producto->id] ?? 0) > 0)
                            <button class="btn btn-sm toggle-alquileres">
                                <img src="{{ asset('imagenes/vermas.jpg') }}" alt="Ver Alquileres">
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <form action="{{ route('productos.actualizar',$producto) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn">
                                    <img src="{{ asset('imagenes/editar.jpeg') }}" alt="Editar" title="Editar" style="width: 25px; height: 25px;">
                                </button>
                            </form>
                            <form action="{{ route('productos.eliminar', $producto) }}" method="POST" onsubmit="return confirmDelete();">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn">
                                    <img src="{{ asset('imagenes/eliminar.jpeg') }}" alt="Eliminar" title="Eliminar" style="width: 25px; height: 25px;">
                                </button>
                            </form>
                        </div>
                    </td>                 
                </tr>
                @endforeach
            </tbody>
        </table>

        @endif
    </div>
</div>

<script>
    $(document).ready(function() {
        const table = $('#example').DataTable({
            info: false,
            ordering: true,
            paging: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            order: [
                [3, 'desc']
            ]
        });

        $('#example').on('click', '.toggle-alquileres', function() {
            const tr = $(this).closest('tr');
            const row = table.row(tr);
            const productoId = tr.data('producto-id');

            if (row.child.isShown()) {
                row.child.hide();
            } else {
                loadAlquileres(productoId, row);
            }
        });
    });

    function loadAlquileres(productoId, row) {
        fetch(`/productos/${productoId}/alquileres`)
            .then(response => response.json())
            .then(data => {
                let alquileresHtml = `
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Precio Total</th>
                            </tr>
                        </thead>
                        <tbody>`;

                data.forEach(alquiler => {
                    alquileresHtml += `
                        <tr>
                            <td>${alquiler.fecha_inicio}</td>
                            <td>${alquiler.fecha_fin}</td>
                            <td>${alquiler.precio_total} €</td>
                        </tr>`;
                });

                alquileresHtml += `</tbody></table>`;
                row.child(alquileresHtml).show();
            })
            .catch(error => console.error('Error al cargar los alquileres:', error));
    }

    function confirmDelete() {
        return confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.');
    }
</script>
@endsection