@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Información de la Ciudad</h1>
        
        <div class="card mx-auto" style="max-width: 500px;">
            <div class="card-body">
                @if($city)
                    <h2 class="card-title">{{ $city->name }}, {{ $city->country }}</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Población: {{ $city->population }}</li>
                        <li class="list-group-item">Latitud: {{ $city->latitude }}</li>
                        <li class="list-group-item">Longitud: {{ $city->longitude }}</li>
                        <li class="list-group-item">¿Es capital?: {{ $city->is_capital ? 'Sí' : 'No' }}</li>
                    </ul>
                @else
                    <p class="text-center">La ciudad no fue encontrada.</p>
                @endif
            </div>
        </div>
    </div>

    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .list-group-item {
            border: none;
        }
    </style>
@endsection
