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
                document.getElementById('loading').innerHTML = '<h2>No hay más productos para mostrar.</h2>';
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