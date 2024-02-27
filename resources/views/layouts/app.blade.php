<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ABP SOLUCIONES</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: #333;
        }
        .nav-link {
            color: #333;
        }
        .nav-link:hover {
            color: #007bff;
        }
        .container {
            margin-top: 40px;
        }
        .jumbotron {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 40px;
        }
        .footer {
            background-color: #333;
            color: #ffffff;
            padding: 20px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .footer p {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    ABP SOLUCIONES
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Entrar') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Salir') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('city.info') }}">{{ __('Guardar ciudad') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('city.saved') }}">{{ __('Mis ciudades') }}</a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <div class="footer text-center">
        <p>&copy; {{ date('Y') }} ABP SOLUCIONES. Creado por José Landázuri.</p>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
