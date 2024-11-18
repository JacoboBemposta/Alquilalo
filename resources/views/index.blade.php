@extends('layouts.menu')

@section('contenido')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<style>

</style>

<div class="col-12 row justify-content-center" style="margin-top: 10vh">
    @if($productosPorFecha->isEmpty())
    <p>No hay productos que cumplan con los criterios.</p>
    @else
    <div class="col-12 col-md-4 product-carousel">
        <div class="row text-center mt-3 p-3">
            <h2 class="section-title">Novedades</h2>
            <div id="carouselNovedades" class="carousel slide justify-content-center" data-bs-ride="carousel" data-bs-interval="2000">
                <div class="carousel-inner">
                    @foreach($productosPorFecha->take(7) as $index => $producto)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="d-flex justify-content-center">
                            @if(!$producto->imagenes->isEmpty())
                            <img class="d-block" style="width:15vw; height: 25vh; box-sizing: border-box;"
                                src="{{ '/storage/productos/' . $producto->id . '/' . $producto->imagenes[0]->nombre }} "
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
            <form action="{{ route('productos.novedades') }}" method="get" class="mt-3 btn-section">
                @csrf
                <button type="submit" class="btn btn-secondary">Ver novedades</button>
            </form>
        </div>
    </div>
    @endif

    @if($productosPorDescuento->isEmpty())
    <p>No hay productos con descuento disponibles.</p>
    @else
    <div class="col-12 col-md-4 product-carousel">
        <div class="row text-center mt-3 p-3">
            <h2 class="section-title">Descuentos</h2>
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
            <form action="{{ route('productos.ofertas') }}" method="get" class="mt-3 btn-section">
                @csrf
                <button type="submit" class="btn btn-secondary">Ver descuentos</button>
            </form>
        </div>
    </div>
    @endif

    @if($productosPorValoracion->isEmpty())
    <p>No hay productos que cumplan con los criterios.</p>
    @else
    <div class="col-12 col-md-4 product-carousel">
        <div class="row text-center mt-3 p-3">
            <h2 class="section-title">Mejor valorados</h2>
            <div id="carouselValoraciones" class="carousel slide justify-content-center" data-bs-ride="carousel" data-bs-interval="2500">
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
                <a class="carousel-control-prev" href="#carouselValoraciones" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselValoraciones" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
            <form action="{{ route('productos.valoraciones') }}" method="get" class="mt-3 btn-section">
                @csrf
                <button type="submit" class="btn btn-secondary">Ver todos</button>
            </form>
        </div>
    </div>
    @endif
</div>




<div class="comofunciona-container" style="margin-top: 25vh">
    <section class="hero-section">
        <h1>Los beneficios de alquilar</h1>
        <p>Comprar es cosa del pasado</p>
    </section>

    <section class="steps-section">
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/costes-mensuales.webp') }}" alt="Costes Mensuales">
            <h2>Costes mensuales bajos</h2>
            <p>Despídete de pagar mucho al comprar y de financiar a largo plazo. Consigue los productos que quieres por muy poco al mes.</p>
        </div>
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/tecnologia.webp') }}" alt="última tecnología">
            <h2>Consigue la última tecnología</h2>
            <p>Disfruta de los productos más nuevos desde su lanzamiento y actualiza el modelo cada año</p>
        </div>
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/residuos.webp') }}" alt="menos residuos">
            <h2>Menos posesión, menos residuos</h2>
            <p>Los productos que vuelven a alquilarse no terminan sin volver a usarse o convertidos en residuos electrónicos, sino que más personas pueden disfrutarlos por más tiempo.</p>
        </div>
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/eligetiempo.webp') }}" alt="gestiona tu tiempo">
            <h2>Alquila el tiempo que quieras</h2>
            <p>¿1, 3, 6 o 12 meses? Elige tu periodo y sigue alquilando al terminar por el mismo precio o devuélvelo gratis.</p>
        </div>
        <div class="step">
        <img class="img-fluid" src="{{ asset('imagenes/seguro.webp') }}" alt="Alquílalo care seguros">
            <h2>Seguro de daños</h2>
            <p>Alquilalo Care ayuda a cubrir todos los costes de una posible reparación. Los signos normales de uso están totalmente cubiertos.</p>
        </div>
    </section>
</div>
<!-- Nueva sección: Localiza tu tienda más cercana -->
<div class="container-map form-container">
    <h2>Localiza tu tienda más cercana</h2>
    <div id="map"></div>
</div>



<!-- JavaScript para abrir mapa -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    // Coordenadas de las tiendas
    const tiendas = [
        {nombre: "Alquilalo Pontevedra, \n C/Sagasta 26", lat: 42.42925347525576,lng: -8.641556452236378},
        {nombre: "Alquilalo Pontevedra, \n Portugal", lat: 39.37029914672128,lng: -8.641556452236378},
         
    ];

    // Inicializamos el mapa
    const map = L.map('map').setView([40.416775, -3.703790], 6); // Centro en España

    // Capa de tiles de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Agrega los marcadores para las tiendas
    tiendas.forEach(tienda => {
        L.marker([tienda.lat, tienda.lng])
            .addTo(map)
            .bindPopup(`<b>${tienda.nombre}</b>`)
            .openPopup();
    });

    // Geolocalización del usuario
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;

            const userMarker = L.marker([userLat, userLng]).addTo(map)
                .bindPopup("<b>Estás aquí</b>")
                .openPopup();

            map.setView([userLat, userLng], 10);

            let tiendaCercana = null;
            let menorDistancia = Infinity;

            tiendas.forEach(tienda => {
                const distancia = map.distance([userLat, userLng], [tienda.lat, tienda.lng]);
                if (distancia < menorDistancia) {
                    menorDistancia = distancia;
                    tiendaCercana = tienda;
                }
            });

            if (tiendaCercana) {
                const tiendaCercanaMarker = L.marker([tiendaCercana.lat, tiendaCercana.lng], {
                        color: 'blue'
                    })
                    .addTo(map)
                    .bindPopup(`${tiendaCercana.nombre}</b><br>Distancia: ${(menorDistancia / 1000).toFixed(2)} km`)
                    .openPopup();

                map.fitBounds([userMarker.getLatLng(), tiendaCercanaMarker.getLatLng()]);
            }
        }, () => {
            alert("No se pudo obtener la ubicación.");
        });
    } else {
        alert("Geolocalización no está soportada en este navegador.");
    }
</script>

@endsection
