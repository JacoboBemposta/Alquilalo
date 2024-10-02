<!-- resources/views/productos/crear.blade.php -->
@extends('layouts.menu')
@section('contenido')
<div class="row justify-content-center mt-3">
    <div class="col-7 p-4 border rounded text-center form-container">
        <img src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre}}" class="img-fluid rounded mx-auto d-block" style="max-width: 100%; height: auto;">
        <h2 class="mt-3">{{ $producto->nombre }}</h2>
        <form action="{{ route('productos.edit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_producto" value="{{ $producto->id }}">
            <input type="hidden" name="disponible" id="disponible" class="form-control mx-auto" style="max-width: 300px;" value="1" >
            <div class="row">
                <div class="col-6 text-center">
                    <h3>Sobre el producto</h3>
                    <div class="form-group text-center">
                        <label for="id_categoria">Selecciona categoria</label>
                        <select name="id_categoria" id="id_categoria" required class="form-control mx-auto" style="max-width: 300px;">
                            <option value="">Seleccione una categoria</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group text-center mt-3">
                        <label for="id_subcategoria">Selecciona subcategoria</label>
                        <select name="id_subcategoria" id="id_subcategoria" required class="form-control mx-auto" style="max-width: 300px;">
                            <option value="">Seleccione una subcategoria</option>
                        </select>
                    </div>
                    <div class="form-group text-center mt-2">
                        <label for="nombre">Nombre del producto</label>
                        <input type="text" name="nombre" id="nombre" class="form-control mx-auto" style="max-width: 300px;" value="{{$producto->nombre}}"readonly>
                    </div>
                    <div class="form-group text-center mt-2">
                        <label for="descripcion">Descripción breve</label>
                        <textarea name="descripcion" id="descripcion" class="form-control mx-auto" style="max-width: 300px;" required>{{ $producto->descripcion }}</textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <label for="preciodia">Precio por día</label>
                        <input type="number" name="precio_dia" id="preciodia" class="form-control mx-auto" value="{{$producto->precio_dia}}"style="max-width: 300px;" required>
                    </div>
                    <div class="form-group text-center mt-4">
                        <label for="preciosemana">Precio por semana</label>
                        <input type="number" name="precio_semana" id="preciosemana" class="form-control mx-auto" value="{{$producto->precio_semana}}"style="max-width: 300px;" required>
                    </div>
                    <div class="form-group text-center mt-4">
                        <label for="preciomes">Precio por mes</label>
                        <input type="number" name="precio_mes" id="preciomes" class="form-control mx-auto" value="{{$producto->precio_mes}}"style="max-width: 300px;" required>
                    </div>
                </div>
                <div class="col-6 text-center">
                    <h3>Características</h3>
                        <div class="form-group text-center">
                            <label for="descuento">Aplicar Descuento</label>
                            <input type="number" name="descuento" id="descuento" class="form-control mx-auto" value="{{$producto->caracteristicas->descuento}}"style="max-width: 300px;" value="0">
                        </div>
                        <div class="form-group text-center">
                            <label for="descripcionlarga">Descripción larga</label>
                            <textarea class="form-control" id="descripcionlarga" name="descripcionlarga" rows="9"  required>{{$producto->caracteristicas->descripcion}}</textarea>
                        </div>
                        <div class="form-group text-center mt-2">
                            <label for="imagenes"></label>
                            <input type="file" name="imagenes[]" id="imagenes" class="form-control-file mx-auto" required multiple>
                        </div>
                        <div class="form-group text-center mt-2">
                            <label for="imagenes"></label>
                            <input type="file" name="imagenes[]" id="imagenes" class="form-control-file mx-auto"  multiple>
                        </div>
                        <div class="form-group text-center mt-2">
                            <label for="imagenes"></label>
                            <input type="file" name="imagenes[]" id="imagenes" class="form-control-file mx-auto"  multiple>
                        </div>
                        <div class="form-group text-center mt-2">
                            <label for="imagenes"></label>
                            <input type="file" name="imagenes[]" id="imagenes" class="form-control-file mx-auto"  multiple>
                        </div>
                        <div class="form-group text-center mt-2">
                            <label for="imagenes"></label>
                            <input type="file" name="imagenes[]" id="imagenes" class="form-control-file mx-auto"  multiple>
                        </div>
                </div>

            </div>
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-secondary    ">Actualizar Datos</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#id_categoria').on('change', function() {
        var categoria_id = $(this).val();
        if (categoria_id) {
            $.ajax({
                url: '/subcategorias/' + categoria_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Actualiza el select de subcategorias
                    $('#id_subcategoria').empty();
                    $.each(data, function(key, value) {
                        $('#id_subcategoria').append('<option value="' + value.id + '">' + value.nombre + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            // Manejo si no se selecciona ninguna categoría
            $('#id_subcategoria').empty();
            $('#id_subcategoria').append('<option value="">Seleccione una subcategoria</option>');
        }
    });
});
</script>
@endsection