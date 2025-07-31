<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Importante para el logging

class GeolocalizacionController extends Controller
{
    /**
     * Muestra una lista de recursos.
     */


    
    public function index()
    {
        try {
            // Asegúrate que sea 'localhost' aquí también, si tu API Node.js está en la misma máquina
            $response = Http::get('http://localhost:3000/Geolocalizacion/');
            return view('geolocalizacion')->with('ResulGeolocalizacion', json_decode($response,true));
        } catch (\Exception $e) {
            // Registra cualquier error que ocurra al intentar obtener los datos iniciales
            Log::error("Error en index de GeolicalizacionController: " . $e->getMessage());
            // Corrección: En lugar de withErrors, pasa un array con el mensaje de error
            // La vista Blade deberá verificar la existencia de 'initialConnectionError'
            return view('geolocalizacion', ['initialConnectionError' => 'No se pudo conectar al servicio inicial de geolocalización. Por favor, verifica que la API de Node.js esté funcionando.']);
        }
    }

    /**
     * Obtiene el detalle de una dirección geográfica por ID desde la API de Node.js.
     * Este método actuará como un proxy.
     */
    public function showDireccionGeografica(string $id)
    {
        try {
            $apiUrl = "http://localhost:3000/Geolocalizacion/direcciones_geograficas/{$id}";
            // Registra la URL a la que se está intentando conectar
            Log::info("Intentando buscar dirección geográfica desde: " . $apiUrl);

            // --- INICIO DE CAMBIOS TEMPORALES PARA DEPURACIÓN ---
            // Esta línea detendrá la ejecución y mostrará el valor de $apiUrl.
            // Si no ves esta salida, significa que la solicitud no está llegando a este método.
            dd($apiUrl);
            // --- FIN DE CAMBIOS TEMPORALES PARA DEPURACIÓN ---

            // Agrega un tiempo de espera (timeout) para que las solicitudes no se queden colgadas
            // y para que los errores de conexión se manifiesten más rápidamente.
            $response = Http::timeout(10)->get($apiUrl); // Timeout de 10 segundos

            // Registra el estado y el cuerpo de la respuesta recibida de la API de Node.js
            Log::info("Respuesta de API de Node.js - Status: " . $response->status());
            Log::info("Respuesta de API de Node.js - Body: " . $response->body());

            // Verifica si la solicitud fue exitosa (códigos de estado 2xx)
            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                // Si la API de Node.js devuelve un error (ej. 404 Not Found, 500 Internal Server Error)
                Log::warning("La API de Node.js no fue exitosa. Status: " . $response->status() . " Body: " . $response->body());
                return response()->json([
                    'message' => 'Error al obtener la dirección geográfica desde la API.',
                    'status_code' => $response->status(),
                    'api_response' => $response->json() // Incluye la respuesta original de la API para depuración
                ], $response->status());
            }
        } catch (\Exception $e) {
            // Captura cualquier excepción que ocurra durante la solicitud HTTP (ej. error de red real, timeout)
            Log::error("Excepción al conectar con el servicio de geolocalización: " . $e->getMessage());
            // --- INICIO DE CAMBIOS TEMPORALES PARA DEPURACIÓN ---
            dd("Excepción capturada: " . $e->getMessage()); // Descomenta esta línea si la ejecución llega aquí
            // --- FIN DE CAMBIOS TEMPORALES PARA DEPURACIÓN ---
            return response()->json([
                'message' => 'Error de conexión con el servicio de geolocalización.',
                'error' => $e->getMessage(), // Muestra el mensaje de la excepción real
            ], 500);
        }
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        //
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(string $id)
    {
        //
    }
}
