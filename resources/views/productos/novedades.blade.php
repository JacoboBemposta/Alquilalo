@extends('layouts.menu')

@section('contenido')
<script src="/js/novedades.js"></script>
<div class="col-12">
    <!-- Contenedor de productos -->
    <div id="product-container" class="row d-flex justify-content-center">
        @foreach($productos->chunk(5) as $chunk)
        <div class="row mt-5 justify-content-center">
            @foreach($chunk as $producto)
            <div class="col-2 d-flex flex-column align-items-center justify-content-center" data-valoracion="{{ round($producto->valoracion_media) }}" id="producto-{{ $producto->id }}">
                <a href="{{ route('productos.verproducto', $producto) }}">
                    <img src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre }}"
                        class="img-fluid mt-5 p-1"
                        style="width: 20vw; height: 20vh">
                </a>
                <div class="row mt-5 flex align-items-center" style="height: 10vh";>
                    <p class="truncate-text">{{ Str::limit($producto->nombre, 30, '...') }}</p>
                </div>
                <div class="rating" style="text-align: center;">
                    <input value="5" name="rate{{ $producto->id }}" id="star5{{ $producto->id }}" type="radio">
                    <label title="5 stars" for="star5{{ $producto->id }}"></label>
                    <input value="4" name="rate{{ $producto->id }}" id="star4{{ $producto->id }}" type="radio">
                    <label title="4 stars" for="star4{{ $producto->id }}"></label>
                    <input value="3" name="rate{{ $producto->id }}" id="star3{{ $producto->id }}" type="radio">
                    <label title="3 stars" for="star3{{ $producto->id }}"></label>
                    <input value="2" name="rate{{ $producto->id }}" id="star2{{ $producto->id }}" type="radio">
                    <label title="2 stars" for="star2{{ $producto->id }}"></label>
                    <input value="1" name="rate{{ $producto->id }}" id="star1{{ $producto->id }}" type="radio">
                    <label title="1 star" for="star1{{ $producto->id }}"></label>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>

    <div id="loading" class=" d-flex flex-column align-items-center justify-content-center" style="display: none;">
        <div class="loader" style="display: none;">

        </div>
    </div>
</div>


@endsection