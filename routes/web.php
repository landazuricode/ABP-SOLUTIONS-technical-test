<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;


// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/info-city', [CityController::class, 'cityInfoForm'])->name('city.info');
    Route::post('/save-city', [CityController::class, 'saveCity'])->name('city.save');
    Route::get('/fetch-states/{country}', [CityController::class, 'fetchStates']);
    Route::get('/fetch-cities/{country}/{state}', [CityController::class, 'fetchCities']);
    Route::get('/fetch-city/{nameCity}', [CityController::class, 'fetchCityInfo']);
    Route::get('/mis-ciudades', [CityController::class, 'savedCities'])->name('city.saved');
    Route::get('/cities/{id}', [CityController::class, 'show'])->name('city.show');
    Route::delete('/delete-city/{id}', [CityController::class, 'deleteCity'])->name('city.delete');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Rutas libres de autenticación
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


Route::get('/', function () {
    return view('welcome');
});
