@extends('layouts.menu')

@section('contenido')

    <div class="col-8 row justify-content-center">

            @if($productosPorFecha->isEmpty())
                <p>No hay productos que cumplan con los criterios.</p>
            @else            
                <div class="col-5">
                    <div class="row text-center mt-3 p-3 m-5">
                        <h2>Novedades</h2>
                        @for ($i = 0; $i < 4; $i++)
                            <div class="col-6 p-2">
                                <div class="image-container">
                                    <img class="img-fluid" src="{{ '/storage/productos/' . $productosPorFecha[$i]->id . '/' . $productosPorFecha[$i]->imagenes[0]->nombre }}" alt="{{ $productosPorFecha[$i]->imagenes[0]->nombre }}">
                                </div>
                            </div>
                        @endfor
                        <form action="{{ route('productos.novedades') }}" method="get">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Ver novedades</button>
                        </form>
                    </div>
                </div>
            @endif
            
            @if($productosPorDescuento->isEmpty())
                <p>No hay productos que cumplan con los criterios.</p>
            @else
                <div class="col-5">
                    <div class="row text-center mt-3 p-3 m-5">
                        <h2>Descuentos</h2>
                        @for ($i = 0; $i < 4; $i++)
                            <div class="col-6 p-2">
                                <div class="image-container">
                                    <img class="img-fluid" src="{{ '/storage/productos/' . $productosPorDescuento[$i]->id . '/' . $productosPorDescuento[$i]->imagenes[0]->nombre }}" alt="{{ $productosPorDescuento[$i]->imagenes[0]->nombre }}">
                                </div>
                            </div>
                        @endfor
                        <form action="{{ route('productos.novedades') }}" method="get">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Ver descuentos</button>
                        </form>
                    </div>
                </div>
            @endif

        </div>

















{{-- 
            @foreach($productosPorFecha as $producto)
                    <h2>{{ $producto->nombre }}</h2>
                    <div class="product-images" >
                        @if($producto->imagenes->count())
                            @foreach($producto->imagenes as $imagen)
                                <img src="{{ '/storage/productos/' . $producto->id . '/' . $imagen->nombre}}"alt="{{$imagen->nombre}} ">
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
