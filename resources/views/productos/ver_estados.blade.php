@extends('layouts.menu')

@section('contenido')
<style>
    img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
}

</style>
<div class="container">
    <h1 class="mb-4">Gestión de Estados: {{ $producto->nombre }}</h1>

    <!-- Información general del producto -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>Detalles del Producto</h5>
            <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
            <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
            <p><strong>Estado Actual:</strong> {{ $producto->estado }}</p>
        </div>
    </div>

    <!-- Botón para cambiar estado -->
    <div class="mb-4">
        <h5>Cambiar Estado del Producto</h5>
        <form action="{{ route('entregas-recogidas.registrar') }}" method="POST">
            @csrf
            <input type="hidden" name="alquiler_id" value="{{ $producto->alquilerActual()?->id }}">
            <div class="mb-3">
                <label for="estado" class="form-label">Nuevo Estado</label>
                <select name="estado" id="estado" class="form-select" required>
                    <option value="">Seleccione un estado</option>
                    <option value="home">Home</option>
                    <option value="entregado">Entregado</option>
                    <option value="en alquiler">En Alquiler</option>
                    <option value="devuelto">Devuelto</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="notas" class="form-label">Notas</label>
                <textarea name="notas" id="notas" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="fotos" class="form-label">Subir Fotos (Opcional)</label>
                <input type="file" name="fotos[]" id="fotos" class="form-control" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Estado</button>
        </form>
    </div>

    <!-- Historial de Estados -->
    <h5>Historial de Estados</h5>
    @forelse ($alquileres as $alquiler)
        <div class="card mb-4">
            <div class="card-header">
                <strong>Alquiler ID:</strong> {{ $alquiler->id }} | 
                <strong>Arrendatario:</strong> {{ $alquiler->arrendatario->name }}
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse ($alquiler->entregasRecogidas as $evento)
                        <li class="list-group-item">
                            <strong>Fecha:</strong> {{ $evento->fecha_evento->format('d-m-Y H:i') }}<br>
                            <strong>Estado:</strong> {{ $evento->estado }}<br>
                            <strong>Notas:</strong> {{ $evento->notas ?? 'N/A' }}<br>
                            @if ($evento->fotos)
                                <strong>Fotos:</strong>
                                <div class="mt-2">
                                    @foreach ($evento->fotos as $foto)
                                        <a href="{{ $foto }}" target="_blank">
                                            <img src="{{ $foto }}" alt="Foto del evento" style="width: 100px; height: auto; margin-right: 10px;">
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </li>
                    @empty
                        <li class="list-group-item">No hay eventos registrados para este alquiler.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    @empty
        <p>No hay alquileres registrados para este producto.</p>
    @endforelse
</div>
@endsection
