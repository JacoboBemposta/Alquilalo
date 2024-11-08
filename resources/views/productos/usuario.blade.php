<!-- resources/views/productosDelUsuario/index.blade.php -->
@extends('layouts.menu')

@section('contenido')

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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productosDelUsuario as $producto)
                <tr>
                    <td>
                        <a href="{{ route('productos.verproducto', $producto) }}">
                            <img src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre }}" class="img-fluid rounded mx-auto d-block" style="max-width: 10vw; height: 10vh;">
                        </a>
                    </td>
                    <td>{{$producto->nombre}}</td>
                    <td>{{$producto->descripcion}}</td>
                    <td>
                        <div class="row mt-5">
                            <form action="{{ route('productos.actualizar',$producto) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <button type="submit" class="btn">
                                <img src="{{ asset('imagenes/editar.jpg') }}" alt="Eliminar" style="width: 50px; height: 50px;">
                            </button>
                            </form>
                            <form action="{{ route('productos.eliminar', $producto) }}" method="POST" enctype="multipart/form-data" onsubmit="return confirmDelete();">
                                @csrf
                                <!-- Este campo indica que el método de la solicitud es DELETE -->
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn">
                                    <img src="{{ asset('imagenes/eliminar.png') }}" alt="Eliminar" style="width: 50px; height: 50px;">
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
    new DataTable('#example', {
    info: false,
    ordering: false,
    paging: false,
    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
    }
});

function confirmDelete() {
        return confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.');
    }
</script>
@endsection
