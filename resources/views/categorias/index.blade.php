@extends('layouts.menu')
@section('contenido')
<div class="row justify-content-center border">
    <div class="col-12 text-center bg-info">
        Contenido del div 
    </div>
</div>
<div class="row justify-content-center border">
    @foreach ($categorias as $categoria)
    <div style="width: 200px; height: 200px; background-color: cyan; margin-top:5px; margin-left:10px;float:left">{{ $categoria->nombre }}
            @if ($categoria->subcategorias->count() > 0)
                <ul>
                    @foreach ($categoria->subcategorias as $subcategoria)
                        <li>{{ $subcategoria->nombre }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach
</div>
@endsection