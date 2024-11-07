<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alquilalo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @yield('css')
    <style>
    /* --------HEADER----------*/

      header {
          width: 100%;
          position: relative;
      }
      .image-container {
            position: relative;
            width: 100%;
            padding-bottom: 100%; /* Mantiene la relación de aspecto cuadrada */
            overflow: hidden;
            /* background-color: #f0f0f0; Color de fondo por si la imagen no carga */
        }
        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain; /* Ajusta la imagen al contenedor */
        }
        .banner {
          background: url('/imagenes/banner.png') no-repeat center; 
          background-size: contain;
          text-align: center;
          padding: 50px 20px;
          height: 20vh; /* Ajusta la altura según sea necesario */
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          margin-top: 2%;
        }
        .form-container {
          background: linear-gradient(180deg, grey 80%, darkgreen 100%);
          padding: 20px;
          border-radius: 10px;
          margin-bottom: 25px;;
        }
        .contenedor-img{
          width: 100%;
          height: 100%; 
          border:solid;
          object-fit: contain;
        }


       /* --------FOOTER----------*/
      
      
       .footer {
   
        bottom: 0;
        width: 100%;
        background-color: #343a40;
        color: #ffffff;
        padding: 20px;
      }



      .footer .container {
          max-width: 1200px; /* Ancho máximo del contenedor */
          margin: 0 auto; /* Centrar el contenedor */
          flex: 1;  /* Hace que el contenido ocupe el espacio restante */
          overflow-y: auto; /* Habilita el scroll cuando el contenido sea demasiado grande */
      }

      .footer h5 {
        color: #ffffff;
        font-size: 12px;
      }

      .footer ul {
        list-style: none;
        padding-left: 0;
      }

      .footer ul li a {
        color: #bbbbbb;
        text-decoration: none;
        font-size: 12px;
        transition: color 0.2s;
      }

      .footer ul li a:hover {
        color: #ffffff;
      }

      /* Estilos específicos para los enlaces de tiendas de aplicaciones */


      .footer img {
          display: block; 
          margin: 0 auto;
      }
      
      /* --------VISTAS FOOTER----------*/


      .faq-section {
            background: linear-gradient(110deg, #e0f7fa 0%, darkgreen 100%);
            padding: 50px 0;
            margin-bottom: 30px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
        }
        .faq-section h1 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 30px;
        }
        .faq-question {
            margin-bottom: 20px;
            color:#1b0b86;
        }
        .faq-answer {
            color:black;
            margin-bottom: 30px;
        }

        /* --------VISTA CATEGORIAS----------*/

        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-title {
            font-weight: bold;
        }

        .list-unstyled li {
            padding: 5px 0;
        }

        .text-muted {
            font-size: 0.9rem;
        }

    </style>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<header>
<div id="app">
  <nav class="navbar navbar-expand-lg bg-body-tertiary ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Alquilalo</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Inicio</a>
            <li class="nav-item">
              <a class="nav-link" href="/categorias">Categorias</a>
            </li>
          </li>
            <a class="nav-link" href="{{ route('productos.novedades') }}">Novedades</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('productos.ofertas') }}">Ofertas</a>
          </li>
          @auth
          <li class="nav-item">
            <a class="nav-link" href="{{ route('productos.create') }}">Subir Producto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/productos/misproductos">Mis productos</a>
          </li>
          @endauth
        </ul>
      </div>
        <ul class="navbar-nav ms-auto">
          @guest
              @if (Route::has('login'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
              @endif

              @if (Route::has('register'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
              @endif
          @else
              <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" 
                  role="button" data-bs-toggle="dropdown" aria-haspopup="true" 
                  aria-expanded="false" v-pre>
                      {{ Auth::user()->name }}
                  </a>

                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </div>
              </li>
          @endguest
        </ul>           
      </div>
    </div>
  </nav>
</header>




  @yield('contenido')


<footer class="footer">
  <div class="container">
    <div class="row mt-4 text-center">
      <div class="col-md-4 text-center">
        <h5>Alquilalo</h5>
        <ul class="list-unstyled">
          <li><a href="{{ url('/general/quienessomos') }}">Quiénes somos</a></li>
          <li><a href="{{ url('/general/comofunciona') }}">Cómo funciona</a></li>
          <li><a href="{{ url('/general/contactanos') }}">Contáctanos</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Soporte</h5>
        <ul class="list-unstyled">
          <li><a href="#">Centro de ayuda</a></li>
          <li><a href="{{ url('/general/normas') }}">Normas de la comunidad</a></li>
          <li><a href="{{ url('/general/preguntas') }}">Preguntas frecuentes</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Legal</h5>
        <ul class="list-unstyled">
          <li><a href="{{ url('/general/avisolegal') }}">Aviso legal</a></li>
          <li><a href="{{ url('/general/condicionesuso') }}">Condiciones de uso</a></li>
          <li><a href="{{ url('/general/politica') }}">Política de privacidad</a></li>
        </ul>
      </div>
    </div>
    <div class="row mt-4 text-center">
      <div class="col-md-4">
        <a href="https://www.apple.com/es/store" target="_blank">
          <img src="/path/apple.jpeg" alt="Apple Store" width="40">
        </a>
      </div>
      <div class="col-md-4">
        <a href="https://appgallery.huawei.com/" target="_blank">
          <img src="/path/app gallery.png" alt="AppGallery" width="40">
        </a>
      </div>
      
      <div class="col-md-4">
        <a href="https://play.google.com/store" target="_blank">
          <img src="/path/google.png" alt="Google Play" width="40">
        </a>
      </div>
    </div>
  </div>
</footer>

  @yield('js')
</body>