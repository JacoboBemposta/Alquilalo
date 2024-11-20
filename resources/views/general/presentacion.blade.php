@extends('layouts.menu') 

@section('contenido')

<style>
        .iframe {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        iframe {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
    </style>

<div class="iframe">
    <iframe 
        src="https://docs.google.com/presentation/d/e/2PACX-1vQXCsi958RN9FKxMMSH6MONcd8r8nks5zeVeApG8sv4sAWNRBCC_pF72Ld4M3vwClzcrCNTNa-VfgzC/embed?start=false&loop=false&delayms=3000" 
        frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true">
    </iframe>
</div>

@endsection