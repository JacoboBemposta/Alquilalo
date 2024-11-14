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

// Evento de scroll para cargar más productos cuando el usuario se acerca al final de la página
window.onscroll = function() {
    // Si el usuario se encuentra cerca del final de la página y no estamos cargando productos
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500 && !loading) {
        loading = true;  // Indica que estamos cargando productos
        page++;  // Incrementa la página
        loadMoreProducts(page);  // Llama a la función para cargar más productos
    }
};

// Función para cargar más productos
function loadMoreProducts(page) {
    let loadingIndicator = document.getElementById('loading'); 
    loadingIndicator.style.display = 'block';  

    // Obtener el valor de búsqueda (si existe) para incluirlo en la solicitud AJAX
    let query = document.getElementById('search-input') ? document.getElementById('search-input').value : '';
    console.log(query);
    // Realiza la solicitud AJAX utilizando fetch
    fetch(`/productos/buscar?page=${page}&query=${encodeURIComponent(query)}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'  // Indica que es una solicitud AJAX
        }
    })
    .then(response => {
        // Si la respuesta no es exitosa, lanza un error
        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }
        return response.json(); // Parsear la respuesta como JSON
    })
    .then(data => {
        if (data.html) {
            // Añadir los productos cargados al contenedor
            document.getElementById('product-container').insertAdjacentHTML('beforeend', data.html);

            // Asignar valoraciones a los nuevos productos cargados
            asignarValoraciones();

            // Si no hay más productos, muestra el mensaje de fin
            if (!data.next_page) {
                document.getElementById('loading').innerHTML = '<h2>No hay más productos para mostrar.</h2>';
            }
        }

        loading = false;  // Permite cargar más productos cuando se haya completado la carga
        loadingIndicator.style.display = 'none';  // Oculta el indicador de carga
    })
    .catch(error => {
        console.error('Error al cargar productos:', error);
        loadingIndicator.style.display = 'none';  // Oculta el indicador de carga en caso de error
    });
}
