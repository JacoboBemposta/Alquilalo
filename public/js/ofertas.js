document.addEventListener("DOMContentLoaded", function() {
    asignarValoraciones();
});

// Función para asignar valoraciones a cada producto basado en el atributo `data-valoracion`
function asignarValoraciones() {
    const productos = document.querySelectorAll('[data-valoracion]');
    
    productos.forEach(producto => {
        const valoracionMedia = producto.getAttribute('data-valoracion');
        const ratingInput = producto.querySelector(`input[value="${valoracionMedia}"]`);
        if (ratingInput) {
            ratingInput.checked = true;
        }
    });
}

// Script para la carga de productos con AJAX
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

    fetch(`/productos/ofertas?page=${page}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        const productContainer = document.getElementById('product-container');
        if (data.html) {
            productContainer.innerHTML += data.html;
            asignarValoraciones();

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
