<!-- resources/views/admin/alquileres/detalles.blade.php -->

@extends('layouts.menu')

@section('contenido')
    <h1>Detalles del Alquiler</h1>
    <p><strong>Producto:</strong> {{ $alquiler->producto->nombre }}</p>
    <p><strong>Arrendatario:</strong> {{ $alquiler->arrendatario->name }}</p>
    <p><strong>Estado:</strong> {{ $alquiler->estado }}</p>
    <p><strong>Fecha Inicio:</strong> {{ $alquiler->fecha_inicio }}</p>
    <p><strong>Fecha Fin:</strong> {{ $alquiler->fecha_fin }}</p>
    <p><strong>Precio Total:</strong> ${{ $alquiler->precio_total }}</p>

    <a href="{{ route('admin.alquileres') }}" class="btn btn-secondary">Volver</a>
@endsection
