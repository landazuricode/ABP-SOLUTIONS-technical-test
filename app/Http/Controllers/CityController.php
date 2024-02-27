<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\SavedCity;


class CityController extends Controller
{
    private $API_URL = "https://api.countrystatecity.in/v1/countries";
    private $COUNTRY_STATE_CITY_API_KEY = "NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA==";
    private $NINJAS_API_KEY = "CHHxKPv3da4/pqhxqERqyA==3bNNAgBB8Eq0PuXR";
   
    // Mostrar el formulario de selección de ciudades
    public function cityInfoForm()
    {
        $response = Http::withHeaders([
            'X-CSCAPI-KEY' => $this->COUNTRY_STATE_CITY_API_KEY,
        ])->get($this->API_URL);
        $countries = $response->json();
        return view('city.info_form', ['countries' => $countries]);
    }

    // Obtener estados de un país
    public function fetchStates($country)
    {
        $response = Http::withHeaders([
            'X-CSCAPI-KEY' => $this->COUNTRY_STATE_CITY_API_KEY,
        ])->get($this->API_URL."/".$country."/states");
        $states = $response->json();
        return $states;
    }
    

    // Obtener ciudades de un estado en un país
    public function fetchCities($country, $state)
    {
        $response = Http::withHeaders([
            'X-CSCAPI-KEY' => $this->COUNTRY_STATE_CITY_API_KEY,
        ])->get($this->API_URL."/".$country."/states/".$state."/cities");
        $cities = $response->json();
        return $cities;
    }
 

    // Obtener información de una ciudad
    public function fetchCityInfo($nameCity)
    {
        $response = Http::withHeaders([
            'X-Api-Key' => $this->NINJAS_API_KEY,
        ])->get("https://api.api-ninjas.com/v1/city?name=".$nameCity);
        $infoCity = $response->json();
        return $infoCity;
    }
    

    // Mostrar las ciudades guardadas por el usuario
    public function savedCities()
    {
        $savedCities = SavedCity::where('user_id', auth()->user()->id)->get();
        return view('city.saved_cities')->with('savedCities', $savedCities);
    }

    // Guardar una ciudad
    public function saveCity(Request $request)
    {
        // Verificar si el usuario ya tiene 5 ciudades guardadas
        $savedCitiesCount = SavedCity::where('user_id', auth()->user()->id)->get();
        $savedCitiesCount = count($savedCitiesCount);
        if ($savedCitiesCount >= 5) {
            return redirect()->back()->with('error', 'No puedes guardar más de 5 ciudades.');
        }

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
        ]);
    
        // Obtener la información de la ciudad
        $infoCity = $this->fetchCityInfo($validatedData['city']);
        
        // Verificar si se obtuvo la información de la ciudad correctamente
        if ($infoCity && is_array($infoCity)) {
            $infoCity = $infoCity[0];
            // Guardar la ciudad en la base de datos
            $savedCity = new SavedCity();
            $savedCity->user_id = auth()->user()->id;
            $savedCity->name = $infoCity['name'];
            $savedCity->latitude = $infoCity['latitude'];
            $savedCity->longitude = $infoCity['longitude'];
            $savedCity->country = $infoCity['country'];
            $savedCity->population = $infoCity['population'];
            $savedCity->is_capital = $infoCity['is_capital'];
            $savedCity->save();
    
            // Redireccionar al usuario a las ciudades creadas
            return redirect('/mis-ciudades')->with('success', 'La ciudad se guardó correctamente.');
        } else {
            // No se pudo obtener la información de la ciudad
            return redirect()->back()->with('error', 'No se pudo recuperar la información de la ciudad.');
        }
    }

    // Mostrar una ciudad
    public function show($id)
    {
        // Buscar la ciudad por su ID 
        $city = SavedCity::find($id);

        // Verificar si la ciudad fue encontrada
        if ($city) {
            // La ciudad existe
            return view('city.show', ['city' => $city]);
        } else {
            // Ciudad no encontrada
            return redirect()->back()->with('error', 'La ciudad no fue encontrada.');
        }
    }

    // Eliminar una ciudad
    public function deleteCity($id)
    {
        // Buscar la ciudad por su ID
        $city = SavedCity::find($id);

        // Verificar si la ciudad pertenece al usuario autenticado
        if ($city && $city->user_id === auth()->user()->id) {
            // Eliminar la ciudad
            $city->delete();
            return redirect('/mis-ciudades')->with('success', 'Ciudad eliminada exitosamente.');
        } else {
            return redirect('/mis-ciudades')->with('error', 'No se pudo eliminar la ciudad.');
        }
    }
}
