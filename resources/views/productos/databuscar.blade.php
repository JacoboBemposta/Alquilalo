<div class="container">
    @foreach($productos->chunk(5) as $chunk)
        <div class="row mt-4 justify-content-center">
            @foreach($chunk as $producto)
                <div class="col-6 col-md-2 d-flex flex-column align-items-center justify-content-center" 
                     data-valoracion="{{ round($producto->valoracion_media) }}" 
                     id="producto-{{ $producto->id }}">
                      <a href="{{ route('productos.verproducto', $producto) }}">
                        <img src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre }}" 
                             class="img-fluid mt-5" 
                             style="max-width: 20vw; height: 20vh">
                    </a>
                    <div class="row">
                        <p class="text-center">{{ $producto->nombre }}</p>
                    </div>
                    <div class="rating">
                        <input value="5" name="rate{{ $producto->id }}" id="star5{{ $producto->id }}" type="radio">
                        <label title="5 estrellas" for="star5{{ $producto->id }}"></label>
                        <input value="4" name="rate{{ $producto->id }}" id="star4{{ $producto->id }}" type="radio">
                        <label title="4 estrellas" for="star4{{ $producto->id }}"></label>
                        <input value="3" name="rate{{ $producto->id }}" id="star3{{ $producto->id }}" type="radio">
                        <label title="3 estrellas" for="star3{{ $producto->id }}"></label>
                        <input value="2" name="rate{{ $producto->id }}" id="star2{{ $producto->id }}" type="radio">
                        <label title="2 estrellas" for="star2{{ $producto->id }}"></label>
                        <input value="1" name="rate{{ $producto->id }}" id="star1{{ $producto->id }}" type="radio">
                        <label title="1 estrella" for="star1{{ $producto->id }}"></label>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
