@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Guardar ciudad') }}</div>
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif


                    <div class="card-body">
                        <form method="POST" action="{{ route('city.save') }}">
                            @csrf

                            <div class="form-group row mb-3">
                                <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('País') }}</label>
                                <div class="col-md-6">
                                    <select id="country" required class="form-control" name="country">
                                        <option value="">Selecciona un país</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country['iso2'] }}">{{ $country['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="state" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                                <div class="col-md-6">
                                    <select id="state" required class="form-control" name="state" disabled>
                                        <option value="">Selecciona un estado</option>
                                    </select>
                                    <div class="spinner-border text-primary d-none" id="stateSpinner" role="status">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>
                                <div class="col-md-6">
                                    <select required id="city" class="form-control" name="city" disabled>
                                        <option value="">Selecciona una ciudad</option>
                                    </select>
                                    <div class="spinner-border text-primary d-none" id="citySpinner" role="status">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="container mb-3">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-header" id="headerInfoCity">Información de la ciudad</div>

                                            <div class="card-body">
                                                <div id="infoCity" style="display:none">
                                                    <p>Nombre: <span id="cityName"></span> </p>
                                                    <p>Latitud: <span id="cityLatitude"></span> </p>
                                                    <p>Longitud: <span id="cityLongitude"></span> </p>
                                                    <p>Código país: <span id="cityCountry"></span> </p>
                                                    <p>Población: <span id="cityPopulation"></span> </p>
                                                    <p>La ciudad es capital: <span id="cityIsCapital"></span> </p>
                                                </div>
                                                <p id="errorInfoCity"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" style="display:none" id="btnSaved" class="btn btn-primary">
                                        {{ __('Guardar ciudad') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
    </div>

    <script>
        // Función para mostrar spinner
        function showSpinner(elementId) {
            document.getElementById(elementId).classList.remove('d-none');
        }

        // Función para ocultar spinner
        function hideSpinner(elementId) {
            document.getElementById(elementId).classList.add('d-none');
        }

        // Función para limpiar información de la ciudad
        function clearCityInfo() {
            document.getElementById("infoCity").style.display = "none";
            document.getElementById("headerInfoCity").style.display = "none";
            document.getElementById("errorInfoCity").innerText = "";
            document.getElementById("cityName").innerText = "";
            document.getElementById("cityLatitude").innerText = "";
            document.getElementById("cityLongitude").innerText = "";
            document.getElementById("cityCountry").innerText = "";
            document.getElementById("cityPopulation").innerText = "";
            document.getElementById("cityIsCapital").innerText = "";
        }

        // Cuando cambia la selección del país
        document.getElementById('country').addEventListener('change', function() {
            clearCityInfo();
            let country = this.value;
            // Reiniciar selectores de estado y ciudad
            document.getElementById('state').innerHTML = '<option value="">Selecciona un país</option>';
            document.getElementById('city').innerHTML = '<option value="">Selecciona una ciudad</option>';
            // Si se selecciona un país, cargar estados
            if (country) {
                showSpinner('stateSpinner');
                fetchStates(country);
                document.getElementById("btnSaved").style.display = "none";
            }
        });

        // Cuando cambia la selección del estado
        document.getElementById('state').addEventListener('change', function() {
            clearCityInfo();
            let country = document.getElementById('country').value;
            let state = this.value;
            // Reiniciar selectores de ciudad
            document.getElementById('city').innerHTML = '<option value="">Selecciona una ciudad</option>';
            // Si se selecciona un estado, cargar ciudades
            if (state) {
                showSpinner('citySpinner');
                fetchCities(country, state);
                document.getElementById("btnSaved").style.display = "none";
            }
        });

        // Cuando cambia la selección de la ciudad
        document.getElementById('city').addEventListener('change', function() {
            clearCityInfo();
            let city = this.value;
            // Si se selecciona una ciudad, cargar información de la ciudad
            if (city) {
                fetchCityInfo(city);
                document.getElementById("btnSaved").style.display = "block";
            }
        });

        // Función para cargar estados desde el controlador
        function fetchStates(country) {
            fetch(`/fetch-states/${country}`)
                .then(response => response.json())
                .then(data => {
                    let stateSelect = document.getElementById('state');
                    data.forEach(state => {
                        let option = document.createElement('option');
                        option.value = state.iso2;
                        option.textContent = state.name;
                        stateSelect.appendChild(option);
                    });
                    stateSelect.disabled = false;
                    hideSpinner('stateSpinner');
                })
                .catch(error => console.error('Error consultando estados:', error));
        }

        // Función para cargar ciudades desde el controlador
        function fetchCities(country, state) {
            fetch(`/fetch-cities/${country}/${state}`)
                .then(response => response.json())
                .then(data => {
                    let citySelect = document.getElementById('city');
                    data.forEach(city => {
                        let option = document.createElement('option');
                        option.value = city.name;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                    citySelect.disabled = false;
                    hideSpinner('citySpinner');
                })
                .catch(error => console.error('Error consultando ciudades:', error));
        }

        // Función para cargar información de la ciudad desde el controlador
        function fetchCityInfo(nameCity) {
            showSpinner('citySpinner');
            fetch(`/fetch-city/${nameCity}`)
                .then(response => response.json())
                .then(data => {
                    hideSpinner('citySpinner');
                    showInfoCity(data[0] || null);
                })
                .catch(error => console.error('Error consultando información de ciudad:', error));
        }

        // Función para mostrar en el DOM la información de la ciudad
        function showInfoCity(data=null){
            if(!data){
                document.getElementById("infoCity").style.display = "none";
                document.getElementById("errorInfoCity").innerText = "No se encontró información de la ciudad";
            }else{
                document.getElementById("headerInfoCity").style.display = "block";
                document.getElementById("infoCity").style.display = "block";
                document.getElementById("errorInfoCity").innerText = "";
                document.getElementById("cityName").innerText = data?.name || "No disponible";
                document.getElementById("cityLatitude").innerText = data?.latitude || "No disponible";
                document.getElementById("cityLongitude").innerText = data?.longitude || "No disponible";
                document.getElementById("cityCountry").innerText = data?.country || "No disponible";
                document.getElementById("cityPopulation").innerText = data?.cityPopulation || "No disponible";
                document.getElementById("cityIsCapital").innerText = data?.is_capital ? "Si" : "No";
            }
        }

    </script>
@endsection
