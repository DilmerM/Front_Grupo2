<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeolocalizacionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LandingPageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas web para tu aplicación.
|
*/


// --- RUTAS PÚBLICAS ---

// Ruta Raíz ('/'): AHORA MUESTRA LA LANDING PAGE.
// Esta será la primera página que vean los usuarios.
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');

// Ruta para MOSTRAR el formulario de login.
// El botón de la landing page apuntará aquí.
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Ruta para MOSTRAR el formulario de registro.
Route::get('/register', [RegisterController::class, 'index'])->name('register');


// --- RUTAS PROTEGIDAS O DE LA APLICACIÓN ---
// Estas son las rutas a las que el usuario accederá después de iniciar sesión.
// En un futuro, se protegerían con un "middleware" de autenticación.

// Ruta principal de la aplicación después del login.
Route::get('/geolocalizacion', [GeolocalizacionController::class, 'index'])->name('geolocalizacion');


// --- RUTAS DE API ---
// Estas rutas son para que tu frontend obtenga datos del backend.

// Ruta para obtener el detalle de una dirección geográfica por ID.
Route::get('/api/direcciones_geograficas/{id}', [GeolocalizacionController::class, 'showDireccionGeografica']);

