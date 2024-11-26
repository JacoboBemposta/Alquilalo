<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Alquilalo</title>
  <link rel="icon" href="/imagenes/logoverde.webp" type="image/png">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  @yield('css')

  <link rel="stylesheet" href="/css/app.css">
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> 
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
  

  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
  <header>
    <div id="app">
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid mt-2">
          <a class="navbar-brand" href="#">
            <img src="/imagenes/logoverde2.png" alt="logo" class="logo-pequeno" style="width: 2vw; height: auto;">
          </a>
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
              @guest
                <li class="nav-item">
                    <a class="nav-link" href="/presentacion">Presentación</a>
                </li>
              @endguest
              @auth
              <li class="nav-item">
                <a class="nav-link" href="{{ route('productos.create') }}">Subir Producto</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/productos/misproductos">Mis productos</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('ofertas.index') }}">Solicitar Producto</a>
              </li>
              @endauth
            </ul>
          </div>
          <!-- Campo de búsqueda -->
          <form class="d-flex ms-auto" action="{{ route('productos.buscar') }}" method="GET" id="search-form">
            @csrf
            <input class="form-control me-2 bg-secondary" type="search" id="search-input" placeholder="Buscar productos..." aria-label="Search" name="query" value="{{ request('query') }}" style="width: 20vw;height: auto;">
          </form>
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
            <a class="d-flex flex-column align-items-center justify-content-center mt-1" href="#">
              <img src="/imagenes/usuario.jpg" alt="logo" class="logo-pequeno mt-2" style="width: 1.5vw; height: auto;">
            </a>
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle mt-3" href="#"
                role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('perfil') }}">
                  Ver Perfil
                </a>
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
            <li><a href="{{ url('/general/contactanos') }}">Centro de ayuda</a></li>
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
            <img src="/imagenes/apple.png" alt="Apple Store" width="40" height="45">
          </a>
        </div>
        <div class="col-md-4">
          <a href="https://appgallery.huawei.com/" target="_blank">
            <img src="/imagenes/huawei.png" alt="AppGallery" width="40" height="45">
          </a>
        </div>

        <div class="col-md-4">
          <a href="https://play.google.com/store" target="_blank">
            <img src="/imagenes/googleplay.png" alt="Google Play" width="40" height="45">
          </a>
        </div>
      </div>
    </div>
  </footer>

  @yield('js')
</body>