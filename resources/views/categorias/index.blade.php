@extends('layouts.menu')

@section('contenido')

<style>
.wrapper {
    position: relative;
    width: 100%;
    height: 66vh;
    position: relative;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.inner {
    --w: 120px;
    --h: 180px;
    --translateZ: 300px;
    --rotateX: -15deg;
    --perspective: 1200px;
    position: absolute;
    width: var(--w);
    height: var(--h);
    top: 25%;
    left: calc(50% - (var(--w) / 2) - 2.5px);

    transform-style: preserve-3d;
    animation: rotating 20s linear infinite;
}
.inner:hover {
    animation-play-state: paused;
}

@keyframes rotating {
    from {
        transform: perspective(var(--perspective)) rotateX(var(--rotateX)) rotateY(0);
    }
    to {
        transform: perspective(var(--perspective)) rotateX(var(--rotateX)) rotateY(1turn);
    }
}

.card {
    position: absolute;
    border: 2px solid rgba(var(--color-card));
    border-radius: 12px;
    overflow: hidden;
    inset: 0;
    transform: rotateY(calc((360deg / var(--quantity)) * var(--index))) translateZ(var(--translateZ));
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(var(--color-card), 0.7);
    color: black;
    transition: transform 0.5s, background-color 0.3s, box-shadow 0.3s;
    cursor: pointer;
}

/* .card:hover {
    transform: scale(2.5);
    background-color: rgba(var(--color-card), 1);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
    z-index: 10000;
} */


/* Estilo de la tarjeta ampliada */
.enlarged-card {
    position: absolute;
    top: 20%; /* Centrado vertical */
    left: 50%; /* Centrado horizontal */
    transform: translate(-50%, -50%); /* Asegura que esté centrada en la pantalla */
    width: 500px; /* Tamaño ajustable de la tarjeta */
    height: auto; /* Permite que la tarjeta crezca si hay muchas subcategorías */
    padding: 20px;
    border-radius: 12px;
    background-color: #bcbec2;
    display: none; /* Inicialmente oculta */
    flex-direction: column; /* Alinea las subcategorías en columna */
    justify-content: center;
    align-items: center;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    z-index: 1000; /* Asegúrate de que esté encima de otros elementos */
    transform: translate(-50%, -50%) !important; /* Evita cualquier rotación */
    opacity: 0.8;
}

/* Hover en la tarjeta ampliada para poder seleccionar las subcategorías sin que la animación continúe */
.enlarged-card:hover {
    animation-play-state: paused; /* Pausa la animación cuando el ratón está sobre la tarjeta */
}

/* Ajusta la apariencia de las subcategorías */
.subcategorias ul {
    list-style-type: none;
    padding: 0;
}

.subcategorias li {
    margin: 10px 0;
}

.subcategorias a {
    color: darkgreen;
    text-decoration: none;
}

.subcategorias a:hover {
    text-decoration: underline;
}
/* 
.enlarged-card .subcategory {
    color: darkgreen;
    margin: 5px 0;
} */
</style>

<div class="wrapper">
    <div class="inner" style="--quantity: {{ count($categorias) }};">
        @foreach($categorias as $index => $categoria)
            <div class="card" 
                style="--index: {{ $index }}; --color-card: {{ rand(100, 255) }}, {{ rand(100, 255) }}, {{ rand(100, 255) }};" 
                onmouseover="showEnlargedCard('{{ $categoria->nombre }}', {{ json_encode($categoria->subcategorias->toArray()) }})">
                <div class="img">{{ $categoria->nombre }}</div>
            </div>
        @endforeach
    </div>
</div>
        <!-- Contenedor para la tarjeta ampliada -->
        <div class="enlarged-card" id="enlargedCard">

</div>


<script>

function showEnlargedCard(categoriaNombre, subcategorias) {
    const enlargedCard = document.getElementById('enlargedCard');
    
    // Obtiene el color de fondo y el color de texto del elemento `card` que activó el evento.
    const selectedCard = event.currentTarget;
    const backgroundColor = getComputedStyle(selectedCard).backgroundColor;
    const textColor = getComputedStyle(selectedCard).color;

    // Aplica los colores capturados al `enlargedCard`.
    enlargedCard.style.display = 'flex';
    enlargedCard.style.backgroundColor = backgroundColor;
    enlargedCard.style.color = textColor;

    // Verifica si `subcategorias` es un array antes de usar `map`.
    if (Array.isArray(subcategorias)) {
        enlargedCard.innerHTML = `
            <h3>${categoriaNombre}</h3>
            <div class="subcategorias">
                <ul>
                    ${subcategorias.map(subcategoria => `
                        <li>
                            <a href="/subcategoria/${subcategoria.id}" style="color: ${textColor};">${subcategoria.nombre}</a>
                        </li>
                    `).join('')}
                </ul>
            </div>
        `;
    } else {
        console.error("Subcategorías no son un array:", subcategorias);
    }
}
// Pausar la animación de las tarjetas cuando el ratón está sobre la tarjeta ampliada
document.querySelector('.enlarged-card').addEventListener('mouseenter', function() {
    document.querySelectorAll('.card').forEach(card => {
        card.style.animationPlayState = 'paused'; // Pausa la animación de las tarjetas
    });
});



// Pausar la animación cuando el ratón está sobre .wrapper
document.querySelector('.inner').addEventListener('mouseenter', function() {
    document.querySelectorAll('.card').forEach(card => {
        card.style.animationPlayState = 'paused'; // Pausa las animaciones de las tarjetas
    });
});

//Reanudar la animación de las tarjetas cuando el ratón sale de .wrapper
document.querySelector('.inner').addEventListener('mouseleave', function() {
    document.querySelectorAll('.card').forEach(card => {
        card.style.animationPlayState = 'running'; // Reanuda las animaciones de las tarjetas
        
    });
});


</script>

@endsection
