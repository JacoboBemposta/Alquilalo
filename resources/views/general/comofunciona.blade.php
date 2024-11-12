@extends('layouts.menu')

@section('contenido')

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
            <h2 class="mt-2">2. Elige tu plan</h2>
            <p class="mt-4">Selecciona el período de tiempo que prefieras para alquilar el producto.</p>
        </div>
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/recibelo.jpg') }}" alt="recibe tu producto">
            <h2 class="mt-2">3. Recógelo en tu tienda más cercana</h2>
            <p>Disponemos de locales en cada núcleo de población donde entregar y recoger los pedidos.</p>
            <p>También puedes solictar que te lo envíen a casa si lo prefieres.</p>
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
<div class="comofunciona-container">
    <section class="hero-section">

        <p>Saca partido de los productos que no usas</p>
    </section>

    <section class="steps-section">
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/producto.png') }}" alt="Elige tu producto">
            <h2>1. Sube tu producto</h2>
            <p>Explora nuestro catálogo y súbelo a la categoría apropiada.</p>
        </div>
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/horario.png') }}" alt="Elige tu plan">
            <h2 class="mt-2">2. Elige tu plan</h2>
            <p class="mt-4">Indica el precio por tiempo de uso.</p>
            <p class="mt-4">Puedes poner precio por día, por semana y por mes</p>
        </div>
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/recibelo.jpg') }}" alt="recibe tu producto">
            <h2 class="mt-2">3. Llévalo a nuestra tienda</h2>
            <p>Si te lo alquilan puedes llevarlo a nuestra tienda.</p>
            <p>También puedes solictar que te lo recojan en casa si lo prefieres.</p>
        </div>
        <div class="step">
            <img class="img-fluid" src="{{ asset('imagenes/devuelvelo.jpg') }}" alt="Disfruta tu producto">
            <h2>4. Recógelo pasado el tiempo de alquiler</h2>
            <p>Puedes dejarlo en la tienda si tienes otro alquiler pendiente.</p>
            <p>Puedes solicitar que te lo enviemos a casa.</p>
        </div>
        <div class="step">
        <img class="img-fluid" src="{{ asset('imagenes/checkOK.jpg') }}" alt="Devuelve tu producto">
            <h2>5. Comprueba el estado del producto</h2>
            <p>Queremos que recibas tu producto en el mejor estado posible.</p>
        </div>      
        <div class="step">
        <img class="img-fluid" src="{{ asset('imagenes/beneficios.png') }}" alt="Valora el producto">
            <h2>6. Recoge tus beneficios</h2>
            <p>Una vez comprobemos que no hay ningún incidente</p>
            <p>te abonaremos el importe correspondiente.</p>
        </div>      
    </section>
</div><br><br>
@endsection
