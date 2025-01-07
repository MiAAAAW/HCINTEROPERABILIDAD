<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ReniecController extends Controller
{
    /**
     * Método para actualizar la credencial de un usuario (contraseña) ante RENIEC.
     * POST /estudiante/reniec/actualizar
     */
    public function actualizarCredencial(Request $request)
    {
        // Validación de campos que se requieren para RENIEC (método Actualizar)
        $request->validate([
            'credencialAnterior' => 'required|string',
            'credencialNueva'    => 'required|string',
            'nuDni'              => 'required|string',
            'nuRuc'              => 'required|string',
        ]);

        // Arma el cuerpo JSON que se enviará al WebService
        $body = [
            'PIDE' => [
                'credencialAnterior' => $request->input('credencialAnterior'),
                'credencialNueva'    => $request->input('credencialNueva'),
                'nuDni'              => $request->input('nuDni'),
                'nuRuc'              => $request->input('nuRuc'),
            ]
        ];

        // Instancia del cliente Guzzle
        $client = new Client([
            'base_uri' => env('PIDE_BASE_URL', 'https://ws2.pide.gob.pe/Rest/RENIEC')
        ]);

        try {
            // Hacemos un POST para Actualizar, pidiendo la respuesta en JSON (?out=json)
            $response = $client->post('Actualizar?out=json', [
                'headers' => [
                    'Content-Type' => 'application/json; charset=UTF-8',
                ],
                'json' => $body
            ]);

            // Procesamos la respuesta
            $statusCode   = $response->getStatusCode(); // 200, 400, 500, etc.
            $responseBody = $response->getBody()->getContents();
            $jsonData     = json_decode($responseBody, true);

            // Retorna la respuesta (puedes adaptarla a tu conveniencia)
            return response()->json([
                'status_code' => $statusCode,
                'data'        => $jsonData
            ], 200);

        } catch (\Exception $e) {
            // Manejo de excepciones (errores de conexión, timeouts, etc.)
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Método para consultar datos de una persona por DNI.
     * POST /estudiante/reniec/consultar
     */
    public function consultarDatos(Request $request)
    {
        // Validación de campos requeridos para RENIEC (método Consultar)
        $request->validate([
            'nuDniConsulta' => 'required|string',
            'nuDniUsuario'  => 'required|string',
            'nuRucUsuario'  => 'required|string',
            'password'      => 'required|string',
        ]);

        // Arma el cuerpo JSON que se enviará al WebService
        $body = [
            'PIDE' => [
                'nuDniConsulta' => $request->input('nuDniConsulta'),
                'nuDniUsuario'  => $request->input('nuDniUsuario'),
                'nuRucUsuario'  => $request->input('nuRucUsuario'),
                'password'      => $request->input('password'),
            ]
        ];

        // Instancia del cliente Guzzle
        $client = new Client([
            'base_uri' => env('PIDE_BASE_URL', 'https://ws2.pide.gob.pe/Rest/RENIEC')
        ]);

        try {
            // Hacemos un POST para Consultar, pidiendo la respuesta en JSON
            $response = $client->post('Consultar?out=json', [
                'headers' => [
                    'Content-Type' => 'application/json; charset=UTF-8',
                ],
                'json' => $body
            ]);

            $statusCode   = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();
            $jsonData     = json_decode($responseBody, true);

            return response()->json([
                'status_code' => $statusCode,
                'data'        => $jsonData,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
