@extends('layouts.menu')

@section('contenido')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-4">Otros usuarios buscan los siguientes productos</h1>
        </div>
    </div>

    <!-- Mensaje de éxito -->
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Listado de items -->
    <div class="row mb-5">
        <div class="col-12">
            @if($items->isEmpty())
                <p class="text-center text-muted">No hay items disponibles por ahora.</p>
            @else
                <div class="row">
                    @foreach ($items as $item)
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->nombre }}</h5>
                                    <p class="card-text text-muted">{{ $item->descripcion }}</p>

                                    <!-- Botón de eliminar o deshabilitar -->
                                    @if (auth()->check() && (auth()->user()->id === $item->user_id || $item->updated_at->lt(now()->subMonth())))
                                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="mt-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary btn-sm w-100" onclick="return confirm('¿Estás seguro de eliminar este item o deshabilitarlo?')">
                                                @if ($item->updated_at->lt(now()->subMonth()))
                                                    Deshabilitar
                                                @else
                                                    Eliminar
                                                @endif
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Formulario para añadir un nuevo item -->
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Solicitar un Producto</h2>
        </div>
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-sm">
                <div class="card-body form-container">
                    <form action="{{ route('ofertas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del item" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="4" placeholder="Describe brevemente el item" required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="bg-secondary btn-block">Publicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
