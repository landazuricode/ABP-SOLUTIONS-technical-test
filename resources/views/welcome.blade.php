@extends('layouts.app')
@section('content')

        <div class="container">
            <div class="jumbotron">
                <h3 class="display-6">Bienvenido(a) a ABP SOLUCIONES</h1>
                <p class="lead">Su portal de información de la ciudad definitivo.</p>
                <hr class="my-4">
                <p>Obtén información detallada sobre cualquier ciudad, guarda tus ciudades favoritas y mucho más.</p>
                <a class="btn btn-primary btn-lg" href="{{ route('city.info') }}" role="button">Crear ciudad</a>
            </div>
        </div>
@endsection
