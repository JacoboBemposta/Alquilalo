@extends('layouts.menu')
@section('contenido')

<style>
.wrapper {
    width: 100%;
    height: 100vh;
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
    z-index: 2;
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

.card:hover {
    transform: scale(2.5);
    background-color: rgba(var(--color-card), 1);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
    z-index: 10000;
}

/* Contenedor para la tarjeta ampliada en la parte inferior */
.enlarged-card {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    width: 300px;
    height: 400px;
    border-radius: 12px;
    background-color: white;
    display: none;
    justify-content: center;
    align-items: center;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    z-index: 2000;
}
</style>

<div class="wrapper">
    <div class="inner" style="--quantity: {{ count($categorias) }};">
        @foreach($categorias as $index => $categoria)
            <div class="card" style="--index: {{ $index }}; --color-card: {{ rand(100, 255) }}, {{ rand(100, 255) }}, {{ rand(100, 255) }};" onmouseover="showEnlargedCard('{{ $categoria['nombre'] }}')">
                <div class="img">{{ $categoria['nombre'] }}</div>
            </div>
        @endforeach
    </div>
</div>
<div class="row justify-content-center border">
    @foreach ($categorias as $categoria)
    <div style="width: 200px; height: 200px; background-color: cyan; margin-top:5px; margin-left:10px;float:left">{{ $categoria->nombre }}
            @if ($categoria->subcategorias->count() > 0)
                <ul>
                    @foreach ($categoria->subcategorias as $subcategoria)
                        <li>{{ $subcategoria->nombre }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach
</div>
@endsection