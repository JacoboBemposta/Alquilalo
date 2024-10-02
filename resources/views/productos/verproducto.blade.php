@extends('layouts.menu')

@section('contenido')
<div class="producto row text-center">
    
    <div class="row col-6 mt-10">

        <!-- Columna de miniaturas de imágenes -->
        <div class="col-4 d-flex flex-column" style="gap: 1px; height:40vh ">
            @for ($i = 0; $i < 5; $i++)
                @if (isset($producto->imagenes[$i]))
                    <img src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[$i]->nombre }}"
                         class="img-thumbnail img-miniatura"
                         style="cursor: pointer; flex: 1; margin-bottom: 1px; height:5vh;object-fit: contain"
                         onclick="cambiarImagen('{{ $producto->imagenes[$i]->nombre }}')">
                @else
                    <div class="img-miniatura "
                         style="flex: 1; margin-bottom: 2px;  height:5vh; width:5ww">
                    </div>
                @endif
            @endfor
        </div>

        <!-- Columna de imagen principal -->
        <div class="col-8 d-flex justify-content-center" >
            <img src="{{ isset($producto->imagenes[0]) ? '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre : '/path/to/placeholder/image.jpg' }}"
                 id="imagenPrincipal"
                 class="img-fluid rounded"
                 style="width: 40vw; height: 40vh; object-fit: contain;" >
        </div>
    </div>
    <div class="col-6" style="font-size: 200%;">
        <h1>Caracteristicas</h1>
        <p><b>Descripcion</b></p> 
        {{ $producto->caracteristicas->descripcion }}
        <p><b>Descuento: </b>{{ $producto->caracteristicas->descuento }}%</p>
        <p><b>Usuario: </b>{{ $producto->usuario->name }}</p>
    </div>


    
</div>

<script>
function cambiarImagen(nombreImagen) {
    // Cambiar la fuente de la imagen principal
    document.getElementById('imagenPrincipal').src = '/storage/productos/{{ $producto->id }}/' + nombreImagen;
}
</script>

<style>
.img-miniatura {
    width: 80%;
    height: 0;
    object-fit: cover; /*Ajusta la imagen para llenar el contenedor y mantener la proporción */ 
}
</style>
@endsection
