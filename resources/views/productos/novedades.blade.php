@extends('layouts.menu')

@section('contenido')
        <div class="col-8">
            <div id="product-container" class="row">
                @foreach($productos->chunk(5) as $chunk)
                    <div class="row mt-4 ">
                        @foreach($chunk as $producto)
                            <div class="col-2 d-flex flex-column align-items-center justify-content-center">
                                <a href="{{ route('productos.verproducto', $producto) }}">
                                    {{-- @dd($producto->imagenes[0]->nombre) --}}
                                    <img src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre }}" class="img-fluid"style="max-width: 10vw; height: 10vh">
                                </a>
                                <p class="text-center">{{ $producto->nombre }}</p>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div id="loading" class="text-center my-4" style="display: none;">
                <p>Cargando más productos...</p>
            </div>
        </div>
        <div class="col-2 bg-info"></div>
    </div>

<script>
    let page = 1;
    let loading = false;

    window.onscroll = function() {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500 && !loading) {
            loading = true;
            page++;
            loadMoreProducts(page);
        }
    };

    function loadMoreProducts(page) {
        let loadingIndicator = document.getElementById('loading');
        loadingIndicator.style.display = 'block';

        fetch(`?page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                    document.getElementById('product-container').innerHTML += data.html;
                    loading = false;
                    loadingIndicator.style.display = 'none';
                } else {
                    loadingIndicator.innerHTML = '<p>No hay más productos para mostrar.</p>';
                }
            })
            .catch(error => {
                console.log(error);
                loadingIndicator.style.display = 'none';
            });
    }
</script>
@endsection


