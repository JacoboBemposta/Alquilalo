@extends('layouts.menu')

@section('contenido')
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-8 form-container">
            <h1 class="faq-question">Normas de la Comunidad</h1>
            <p class="faq-answer">Bienvenido a nuestras normas de la comunidad. Por favor, léelas cuidadosamente.</p>

            <h2 class="faq-question">Norma 1: Respeto</h2>
            <p class="faq-answer">Todos los miembros de la comunidad deben tratar a los demás con respeto. No se tolerarán insultos ni acosos.</p>

            <h2 class="faq-question">Norma 2: Contenido Apropiado</h2>
            <p class="faq-answer">Los usuarios deben asegurarse de que todo el contenido compartido sea apropiado y no ofensivo.</p>

            <h2 class="faq-question">Norma 3: Privacidad</h2>
            <p class="faq-answer">Respeta la privacidad de los demás. No compartas información personal sin consentimiento.</p>

            <h2 class="faq-question">Norma 4: Comportamiento Constructivo</h2>
            <p class="faq-answer">Fomenta el debate saludable y constructivo. Las críticas deben ser respetuosas y orientadas a la mejora.</p>

            <h2 class="faq-question">Norma 5: Cumplimiento de las Reglas</h2>
            <p class="faq-answer">Cualquier violación de estas normas puede resultar en la eliminación del contenido o la suspensión de la cuenta.</p>

            <h2 class="faq-question">Contacto</h2>
            <p class="faq-answer">Si tienes alguna pregunta sobre estas normas, no dudes en <a href="{{ url('/general/contactanos') }}">contactarnos</a>.</p>
        </div>
    </div>
</div>
@endsection
