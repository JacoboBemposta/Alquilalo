@extends('layouts.menu')

@section('contenido')
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-8">
            <section class="form-container">
                <h1>Preguntas frecuentes</h1>
                <div class="faq-question">
                    <h4>¿Qué es Alquilalo?</h4>
                    <div class="faq-answer">
                        <p>Alquilalo es una plataforma de alquiler entre particulares o profesionales. Actuamos de intermediarios entre el que ofrece algo y el que busca un artículo concreto para alquilar.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Cualquiera puede alquilar cosas a otras personas?</h4>
                    <div class="faq-answer">
                        <p>Sí, cualquiera puede tanto pedir artículos en alquiler, como alquilar los suyos a otras personas.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Qué significa alquilar como profesional?</h4>
                    <div class="faq-answer">
                        <p>Las condiciones como profesional son un poco diferentes. Por ejemplo, si eres un profesional de alquiler de coches, seguramente ya tendrás un seguro de flota que puedes usar cuando te alquilan un coche, en vez de pagar un seguro (obligatorio por ley) que incluya la cobertura cuando el coche está en alquiler, como tienen que hacer los particulares.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Qué cosas puedo poner en alquiler?</h4>
                    <div class="faq-answer">
                        <p>Puedes poner en alquiler prácticamente cualquier cosa (que sea legal y te pertenezca), desde un kayak hasta un piano. Y también puedes ofrecer servicios, como rutas en kayak o clases de piano.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Qué precio debo poner a mis artículos?</h4>
                    <div class="faq-answer">
                        <p>El importe mínimo del alquiler de un artículo es de 3€/unidad de tiempo elegida. Puedes poner el precio que consideres oportuno. El precio se puede fijar por hora, día, semana o mes.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Puedo poner en alquiler mi coche / camper / autocaravana?</h4>
                    <div class="faq-answer">
                        <p>Sí. Es obligatorio que tu seguro cubra explícitamente el alquiler a terceros del vehículo sin conductor, y nosotros nos encargamos de contratarlo sólo para los días que tengas el vehículo alquilado a otra persona.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Qué puedo hacer si no encuentro lo que busco?</h4>
                    <div class="faq-answer">
                        <p>Si necesitas algo que no está publicado en la plataforma, puedes solicitarlo publicando una búsqueda en nuestra sección "Solicitar Producto". Funciona como un tablón de anuncios donde describes brevemente el artículo buscado.Podrás eliminar tus publicaciones cuando quieras o deshabilitarlas pasado 1 mes.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Por qué es obligatorio ponerle una fianza a mi artículo?</h4>
                    <div class="faq-answer">
                        <p>En muchas categorías es obligatorio establecer, para todos los artículos que pongas en alquiler, una fianza por un mínimo de un porcentaje del valor del artículo, como garantía frente a daños. Cuando se confirma el alquiler no cobramos la fianza, sino que le pedimos al banco que la bloquee en la tarjeta de quien ha pedido el alquiler. Si al final del alquiler se devuelve el artículo sin daños, la fianza se desbloquea de nuevo a las 24h.</p>
                        <p>Está comprobado que al fijar una fianza, la gente cuida mucho más los artículos que alquila y le da seguridad a los propietarios.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Cuánto cuesta alquilar en Alquilalo?</h4>
                    <div class="faq-answer">
                        <p>En Alquilalo, nuestro modelo de precios es sencillo y transparente. Por cada alquiler, cobramos una comisión del <strong>5% del total del alquiler</strong>, que se destina a cubrir los gastos de gestión de la plataforma.</p>
                        <p>Es importante tener en cuenta que este porcentaje se aplica solo al precio del alquiler, no a la fianza, que se paga de manera separada para garantizar el buen uso del producto alquilado.</p>
                        <p>Además, los arrendadores tienen la tranquilidad de saber que nuestro sistema de gestión ayuda a facilitar todo el proceso de alquiler de forma segura y eficiente.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Cuándo me devuelven la fianza?</h4>
                    <div class="faq-answer">
                        <p>Si devuelves el artículo sin incidencias, 24 horas después de terminar el alquiler, se reintegrará automáticamente.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Cómo abro una incidencia?</h4>
                    <div class="faq-answer">
                        <p>Puedes abrir una incidencia desde la seccion de ayuda enviándos un correo.</p>
                        <p>También abrirla desde tu perfil adjuntando una imagen si hay una incidencia física</p>
                        <p>Como arrendatario puedes abrir incidencia en cualquier momento desde el inicio del alquiler</p>
                        <p>Como arrendador puedes abrir una incidencia desde el fin del alquiler hasta pasadas 24 horas.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>Si me alquilan un artículo, ¿cuándo cobro?</h4>
                    <div class="faq-answer">
                        <p>Una vez que te devuelvan el artículo, tienes 24 horas para abrir una incidencia si encuentras cualquier problema. Si (como esperamos) todo ha ido bien y no hay ningún problema, pasado ese plazo ordenaremos automáticamente el pago a tu cuenta. Actualmente no podemos realizar pagos antes de que pase una semana desde que el usuario te pidió el artículo, por el sistema que usan nuestros proveedores de pago con tarjeta para detección de fraude, etc.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Y si me alquilan un artículo y no me pagan?</h4>
                    <div class="faq-answer">
                        <p>En el momento en que realizan una solicitud de alquiler, al solicitante se le cobra el importe del alquiler y se reserva en su tarjeta el importe de la fianza. Tienes garantizado el cobro del alquiler al final del plazo.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Quién se encarga del transporte, el dueño del artículo o la persona que lo solicita?</h4>
                    <div class="faq-answer">
                        <p>El arrendador debe llevar el producto antes del inicio del alquiler a nuestra sede donde lo recogerá el arrendatario. Se procederá de la misma forma para la devolución del artículo.</p>
                        <p>Próximamente también tendremos servicio de transporte.</p>

                    </div>
                </div>
                <div class="faq-question">
                    <h4>Me han devuelto un artículo dañado, pero me he dado cuenta después de recogerlo</h4>
                    <div class="faq-answer">
                        <p>Tienes 24h después de recoger un artículo para abrir una incidencia. Asegúrate de que las fotos de la entrega y recogida muestren el artículo con el mejor detalle posible para demostrar los daños. Ahí es donde entra la fianza en juego. Se te pagaría ese dinero (o el porcentaje en caso de daños menores) que se haya considerado como seguro para cubrirlos, tomando como base las fotos para llegar a un acuerdo de costes.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Qué pasa si el propietario no entrega el artículo?</h4>
                    <div class="faq-answer">
                        <p>El usuario debe abrir una incidencia y el equipo de soporte resolverá el problema. Si el propietario se desentiende del proceso de alquiler, el dinero será reembolsado al usuario. Los gastos de la plataforma, seguro y entrega a domicilio (si existiesen), serán cobrados al propietario por no cumplir su parte del acuerdo.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Qué pasa si el arrendatario no devuelve el artículo al propietario?</h4>
                    <div class="faq-answer">
                        <p>Además del cobro de la fianza. Conforme a la legislación, actuaríamos como intermediarios y facilitaríamos los datos del arrendatario a la policía para interponer una denuncia.</p>
                    </div>
                </div>
                <div class="faq-question">
                    <h4>¿Cómo funciona el sistema de fianzas y seguro?</h4>
                    <div class="faq-answer">
                        <p>Alquílalo trabaja conjuntamente con una empresa de seguros. El arrendador decide si poner o no una fianza. Se aplica, por norma general, un incremento del 10% para el seguro.</p>
                    </div>
                </div>                
            </section>
        </div>  
    </div>
</div>

@endsection