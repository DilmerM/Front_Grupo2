<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeolicalizacionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta principal que carga la vista de geolocalización
Route::get('/', function () {
    return view('geolocalizacion');
});

// Ruta para obtener el listado de geolocalizaciones (si tu GeolocalizacionController::index
// está diseñado para esto). Se mantiene la ruta '/geolocalizacion' para este propósito.
Route::get('/geolocalizacion', [GeolicalizacionController::class, 'index']);

// Nueva ruta para obtener el detalle de una dirección geográfica por ID
// Esta ruta es la que tu JavaScript en el Blade llamará.
Route::get('/api/direcciones_geograficas/{id}', [GeolicalizacionController::class, 'showDireccionGeografica']);
