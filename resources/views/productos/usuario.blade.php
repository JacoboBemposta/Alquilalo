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
                        <div class="row">
                            <form action="{{ route('productos.actualizar',$producto) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <button type="submit" class="m-2 col-4 btn btn-outline-secondary">Editar</button>
                            </form>
                            <form action="{{ route('productos.eliminar',$producto) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="m-2 col-4 btn btn-outline-danger">Eliminar</button>
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
</script>
@endsection
