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
        src="https://docs.google.com/presentation/d/e/2PACX-1vQLwSooHHmzeHIwrtSLuO6s2XC1SdZCtlZkEuFv9qqqEFP5U48KfdM--R0sZKC5ciPFQWTHrJ1UyjOL/embed?start=false&loop=false&delayms=3000" 
        frameborder="0" 
        width="960" 
        height="569" 
        allowfullscreen="true" 
        mozallowfullscreen="true" 
        webkitallowfullscreen="true">
    </iframe>
</div>

@endsection