@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Ciudades Guardadas</h1>
    @if($savedCities->isEmpty())
        <div class="alert alert-info" role="alert">
            No tienes ciudades guardadas.
        </div>
    @else
        <ul class="list-group">
            @foreach($savedCities as $city)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a style="text-decoration:none;" href="{{ route('city.show', $city->id) }}">
                    <div>
                            {{ $city->city_name }}
                            <small class="text-muted">{{ $city->name }}, {{ $city->country }} - Consultado el {{ $city->created_at->format('d/m/Y H:i:s') }}</small>
                        </div>
                    </a>
                    <form action="{{ route('city.delete', $city->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
