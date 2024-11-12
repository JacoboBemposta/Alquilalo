@extends('layouts.menu')

@section('contenido')
<link rel="stylesheet" href="/css/tarjetas.css">
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
        <div class="enlarged-card mt-5" id="enlargedCard">

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
