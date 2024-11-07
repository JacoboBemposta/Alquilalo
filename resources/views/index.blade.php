@extends('layouts.menu')

@section('contenido')
<style>
    .carousel-inner img {
        width: 120%;
        height: auto;
        /* Cambiar a auto para mantener la proporción */
        box-sizing: border-box;
    }
</style>

<div class="col-12 row justify-content-center">
    @if($productosPorFecha->isEmpty())
    <p>No hay productos que cumplan con los criterios.</p>
    @else
    <div class="col-4">
        <div class="row text-center mt-3 p-3 m-5">
            <h2>Novedades</h2>
            <div id="carouselNovedades" class="carousel slide justify-content-center" data-bs-ride="carousel" data-bs-interval="2000">
                <div class="carousel-inner">
                    @foreach($productosPorFecha->take(7) as $index => $producto)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="d-flex justify-content-center">
                            @if(!$producto->imagenes->isEmpty())
                            <img class="d-block" style="width:15vw; height: 25vh; box-sizing: border-box;"
                                src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre }}"
                                alt="{{ $producto->nombre }}">
                            @else
                            <p>Imagen no disponible</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselNovedades" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselNovedades" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
            <form action="{{ route('productos.novedades') }}" method="get" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-secondary">Ver novedades</button>
            </form>
        </div>
    </div>
    @endif

    @if($productosPorDescuento->isEmpty())
    <p>No hay productos que cumplan con los criterios.</p>
    @else
    <div class="col-4">
        <div class="row text-center mt-3 p-3 m-5">
            <h2>Descuentos</h2>
            <div id="carouselDescuentos" class="carousel slide justify-content-center" data-bs-ride="carousel" data-bs-interval="2200">
                <div class="carousel-inner">
                    @foreach($productosPorDescuento->take(7) as $index => $producto)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="d-flex justify-content-center">
                            @if(!$producto->imagenes->isEmpty())
                            <img class="d-block" style="width:15vw; height: 25vh; box-sizing: border-box;"
                                src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre }}"
                                alt="{{ $producto->nombre }}">
                            @else
                            <p>Imagen no disponible</p>
                            @endif
                        </div>
                    </div>
                    @endforeach

                </div>
                <a class="carousel-control-prev" href="#carouselDescuentos" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselDescuentos" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
            <form action="{{ route('productos.ofertas') }}" method="get" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-secondary">Ver descuentos</button>
            </form>
        </div>
    </div>
    @endif

    @if($productosPorValoracion->isEmpty())
    <p>No hay productos que cumplan con los criterios.</p>
    @else
    <div class="col-4">
        <div class="row text-center mt-3 p-3 m-5">
            <h2>Mejor valorados</h2>
            <div id="carouselDescuentos" class="carousel slide justify-content-center" data-bs-ride="carousel" data-bs-interval="2500">
                <div class="carousel-inner">
                    @foreach($productosPorValoracion->take(7) as $index => $producto)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="d-flex justify-content-center">
                            @if(!$producto->imagenes->isEmpty())
                            <img class="d-block" style="width:15vw; height: 25vh; box-sizing: border-box;"
                                src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre }}"
                                alt="{{ $producto->nombre }}">
                            @else
                            <p>Imagen no disponible</p>
                            @endif
                        </div>
                    </div>
                    @endforeach

                </div>
                <a class="carousel-control-prev" href="#carouselDescuentos" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselDescuentos" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
            <form action="{{ route('productos.valoraciones') }}" method="get" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-secondary">Ver todos</button>
            </form>
        </div>
    </div>
    @endif
</div>

<br><br><br>
















{{--
            @foreach($productosPorFecha as $producto)
                    <h2>{{ $producto->nombre }}</h2>
<div class="product-images">
    @if($producto->imagenes->count())
    @foreach($producto->imagenes as $imagen)
    <img src="{{ '/storage/productos/' . $producto->id . '/' . $imagen->nombre}}" alt="{{$imagen->nombre}} ">
    @endforeach
    @else
    <p>No hay imágenes disponibles para este producto.</p>
    @endif
</div>
<p>Descripcion: {{ $producto->descripcion }}</p>
<p>Precio por día: {{ $producto->precio_dia }}</p>
<p>Precio por semana: {{ $producto->precio_semana }}</p>
<p>Precio por mes: {{ $producto->precio_mes }}</p>
<p>Disponible: {{ $producto->disponible ? 'Sí' : 'No' }}</p>

<!-- Mostrar características -->
<h3>Características:</h3>
<ul>
    @foreach($producto->caracteristicas as $caracteristica)
    <li>
        <p>Novedad: {{ $caracteristica->novedad }}</p>
        <p>Descuento: {{ $caracteristica->descuento }}</p>
    </li>
    @endforeach
</ul>

@endforeach --}}

@endsection