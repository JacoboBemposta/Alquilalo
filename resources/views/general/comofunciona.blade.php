@extends('layouts.menu')

@section('contenido')
<style>
    .comofunciona-container {
    font-family: 'Arial', sans-serif;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.hero-section {
    text-align: center;
    margin-bottom: 2rem;
}

.hero-section h1 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.hero-section p {
    font-size: 1.2rem;
    color: #555;
}

.steps-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;   
}
.steps-section img {
    width: 30%; /* Asegura que las imágenes llenen su contenedor */
    height: 30%; /* Ajusta la altura de las imágenes */
    object-fit: cover; /* Mantiene la relación de aspecto */
}
.step {
    background: #f8f8f8;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.step h2 {
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
    color: #333;
}

.step p {
    font-size: 1rem;
    color: #666;
}

</style>
<div class="comofunciona-container">
    <section class="hero-section">
        <h1>Cómo funciona</h1>
        <p>Explora cómo puedes disfrutar de cualquier producto de manera flexible.</p>
    </section>

    <section class="steps-section">
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/producto.png') }}" alt="Elige tu producto">
            <h2>1. Encuentra tu producto</h2>
            <p>Explora nuestro catálogo y elige el producto que deseas.</p>
        </div>
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/horario.png') }}" alt="Elige tu plan">
            <h2>2. Elige tu plan</h2>
            <p>Selecciona el período de tiempo que prefieras para alquilar el producto.</p>
        </div>
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/recibelo.jpg') }}" alt="recibe tu producto">
            <h2>3. Recíbelo en casa</h2>
            <p>Te enviamos el producto rápidamente para que puedas empezar a usarlo.</p>
            <p>También puedes recogerlo en nuestra sede si lo prefieres</p>
        </div>
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/disfrutalo.png') }}" alt="Disfruta tu producto">
            <h2>4. Disfruta del producto</h2>
            <p>Es el momento de disfrutar del producto que deseas.</p>
        </div>
        <div class="step">
        <img class="img-fluid" src="{{ asset('imagenes/devuelvelo.jpg') }}" alt="Devuelve tu producto">
            <h2>5. Devuelvelo</h2>
            <p>Cuando ya no lo necesites, devuélvelo fácilmente.</p>
        </div>      
        <div class="step">
        <img class="img-fluid" src="{{ asset('imagenes/valoralo.png') }}" alt="Valora el producto">
            <h2>6. valóralo</h2>
            <p>Si lo deseas, puedes puntuar el producto y ayudar a otros usuarios a decidirse.</p>
        </div>      
    </section>
</div><br><br>
<div class="comofunciona-container mt-5">
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
@endsection
