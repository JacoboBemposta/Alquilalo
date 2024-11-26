@extends('layouts.menu')

@section('contenido')
<div class="container">
    <h1 class="mb-4 mt-5">Gestión de Alquileres</h1>

    <!-- Verificación si el usuario es administrador -->
    @if(auth()->user()->is_admin == true)

    <div class="table-responsive mt-5 mb-5">
        <table class="table table-striped mt-5 mb-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Arrendatario</th>
                    <th>Arrendador</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $alquiler->id }}</td>
                    <td>{{ $alquiler->producto->nombre }}</td>
                    <td>{{ $alquiler->arrendatario->name }}</td>
                    <td>{{ $alquiler->arrendador->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($alquiler->fecha_inicio)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($alquiler->fecha_fin)->format('d-m-Y') }}</td>
                    <td>
                        <!-- Desplegable para seleccionar el estado -->
                        <form action="{{ route('admin.cambiar_estado', $alquiler->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="estado" class="form-control">
                                <!-- Verifica si el estado actual coincide y marca como seleccionado -->
                                <option value="home" {{ $estado === 'home' ? 'selected' : '' }}>Home</option>
                                <option value="entregado" {{ $estado === 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="en alquiler" {{ $estado === 'en alquiler' ? 'selected' : '' }}>En Alquiler</option>
                                <option value="devuelto" {{ $estado === 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                            </select>
                    </td>
                    <td>
                    <button type="submit" class="btn btn-warning btn-sm mt-2">Actualizar Estado</button>
                    </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
