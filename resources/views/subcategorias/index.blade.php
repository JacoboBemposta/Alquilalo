@extends('layouts.menu')

@section('contenido')
<div class="col-12">
    <!-- Contenedor de productos -->
    <div id="product-container" class="row d-flex justify-content-center">
        @foreach($productos->chunk(5) as $chunk)
            <div class="row mt-4 justify-content-center">
                @foreach($chunk as $producto)
                    <div class="col-2 d-flex flex-column align-items-center justify-content-center" data-valoracion="{{ round($producto->valoracion_media) }}" id="producto-{{ $producto->id }}">
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

    <div id="loading" class="text-center my-4" style="display: none;">
        <p>Cargando más productos...</p>
    </div>
</div>

<script>

document.addEventListener("DOMContentLoaded", function() {
    // Asigna las valoraciones iniciales cuando la página carga por primera vez
    asignarValoraciones();
});

// Función para asignar valoraciones a cada producto basado en el atributo `data-valoracion`
function asignarValoraciones() {
    // Selecciona todos los productos que tienen el atributo `data-valoracion`
    const productos = document.querySelectorAll('[data-valoracion]');
    
    productos.forEach(producto => {
        const valoracionMedia = producto.getAttribute('data-valoracion');
        
        // Selecciona el input de radio correspondiente a la valoración del producto
        const ratingInput = producto.querySelector(`input[value="${valoracionMedia}"]`);
        
        if (ratingInput) {
            ratingInput.checked = true; // Marca la estrella adecuada
        }
    });
}

// Variables de control para paginación
let page = 1;
let loading = false;

window.onscroll = function() {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500 && !loading) {
        loading = true;
        page++;
        loadMoreProducts(page);
    }
};

// Función para cargar más productos al hacer scroll
function loadMoreProducts(page) {
    let loadingIndicator = document.getElementById('loading');
    loadingIndicator.style.display = 'block';

    fetch(`/productos/novedades?page=${page}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'  // Indica que es una solicitud AJAX
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }
        return response.json(); // Parsear como JSON si la respuesta es exitosa
    })
    .then(data => {
        if (data.html) {
            // Agregar los productos cargados al contenedor
            document.getElementById('product-container').innerHTML += data.html;

            // Asignar valoraciones a los nuevos productos cargados
            asignarValoraciones();

            // Si no hay más productos, muestra el mensaje de fin
            if (!data.next_page) {
                document.getElementById('loading').innerHTML = '<p>No hay más productos para mostrar.</p>';
            }
        }

        loading = false;
        loadingIndicator.style.display = 'none';
    })
    .catch(error => {
        console.error('Error al cargar productos:', error);
        loadingIndicator.style.display = 'none';
    });
}


</script>






@endsection



