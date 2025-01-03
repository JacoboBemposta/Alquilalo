<!-- resources/views/productos/crear.blade.php -->
@extends('layouts.menu')
@section('contenido')
<div class="row justify-content-center mt-3">
    <div class="col-md-6 p-4 border rounded form-container">
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- @method('PUT') --}}
           
            <input type="hidden" name="id_usuario" value="{{ $user_id }}">
            <input type="hidden" name="disponible" id="disponible" class="form-control mx-auto" style="max-width: 300px;" value="1" >
            <div class="row">
                <div class="col-6 text-center">
                    <h3>Sobre el producto</h3>
                    <div class="form-group text-center">
                        <label for="id_categoria">Selecciona categoria</label>
                        <select name="id_categoria" id="id_categoria" class="form-control mx-auto" style="max-width: 300px;">
                            <option value="">Seleccione una categoria</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group text-center mt-3">
                        <label for="id_subcategoria">Selecciona subcategoria</label>
                        <select name="id_subcategoria" id="id_subcategoria" class="form-control mx-auto" style="max-width: 300px;">
                            <option value="">Seleccione una subcategoria</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <label for="nombre">Nombre del producto</label>
                        <input type="text" name="nombre" id="nombre" class="form-control mx-auto" style="max-width: 300px;" required>
                    </div>
                    <div class="form-group text-center">
                        <label for="descripcion">Descripción breve</label>
                        <textarea name="descripcion" id="descripcion" class="form-control mx-auto" style="max-width: 300px;" placeholder="Descripcion breve" required></textarea>
                    </div>
                    <div class="form-group text-center">
                        <label for="preciodia">Precio por día</label>
                        <input type="number" name="precio_dia" id="preciodia" class="form-control mx-auto" style="max-width: 300px;" required>
                    </div>
                    <div class="form-group text-center">
                        <label for="preciosemana">Precio por semana</label>
                        <input type="number" name="precio_semana" id="preciosemana" class="form-control mx-auto" style="max-width: 300px;" required>
                    </div>
                    <div class="form-group text-center">
                        <label for="preciomes">Precio por mes</label>
                        <input type="number" name="precio_mes" id="preciomes" class="form-control mx-auto" style="max-width: 300px;" required>
                    </div>
                </div>
                <div class="col-6 text-center">
                    <h3>Características</h3>
                    <div class="form-group text-center">
                        <label for="descuento">Descuento</label>
                        <input type="number" name="descuento" id="descuento" class="form-control mx-auto" style="max-width: 300px;" value="0">
                    </div>
                    <div class="form-group text-center">
                        <label for="descripcionlarga">Descripción larga</label>
                        <textarea class="form-control" id="descripcionlarga" name="descripcionlarga" rows="9" placeholder="Describe el producto" required></textarea>
                    </div>
                    <div class="form-group text-center">
                        <label for="imagenes">Imágenes</label>
                        <input type="file" name="imagenes[]" id="imagenes" class="form-control-file mx-auto" required multiple>
                    </div>
                    <div class="form-group text-center">
                        <label for="imagenes">Imágenes</label>
                        <input type="file" name="imagenes[]" id="imagenes" class="form-control-file mx-auto"  multiple>
                    </div>
                    <div class="form-group text-center">
                        <label for="imagenes">Imágenes</label>
                        <input type="file" name="imagenes[]" id="imagenes" class="form-control-file mx-auto"  multiple>
                    </div>
                    <div class="form-group text-center">
                        <label for="imagenes">Imágenes</label>
                        <input type="file" name="imagenes[]" id="imagenes" class="form-control-file mx-auto"  multiple>
                    </div>
                    <div class="form-group text-center mt-2">
                        <label for="imagenes">Imágenes</label>
                        <input type="file" name="imagenes[]" id="imagenes" class="form-control-file mx-auto"  multiple>
                    </div>
                </div>

            </div>
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-secondary">Subir Producto</button>
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