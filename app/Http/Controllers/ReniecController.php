<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ReniecController extends Controller
{
    /**
     * Actualiza la credencial (contraseña) del usuario en RENIEC/PIDE.
     * Endpoint local: POST /estudiante/reniec/actualizar
     */
    public function actualizarCredencial(Request $request)
    {
        // 1. Validar los campos necesarios
        $request->validate([
            'credencialAnterior' => 'required|string',
            'credencialNueva'    => 'required|string',
            'nuDni'              => 'required|string',
            'nuRuc'              => 'required|string',
        ]);

        // 2. Preparar el cuerpo JSON
        $body = [
            'PIDE' => [
                'credencialAnterior' => $request->input('credencialAnterior'),
                'credencialNueva'    => $request->input('credencialNueva'),
                'nuDni'              => $request->input('nuDni'),
                'nuRuc'              => $request->input('nuRuc'),
            ]
        ];

        // 3. Instanciar el cliente Guzzle
        $client = new Client([
            'base_uri' => env('PIDE_BASE_URL') // "https://ws2.pide.gob.pe/Rest/RENIEC"
        ]);

        try {
            // 4. POST a "/Actualizar?out=json"
            $response = $client->post('Actualizar?out=json', [
                'headers' => [
                    'Content-Type' => 'application/json; charset=UTF-8',
                ],
                'json' => $body
            ]);

            // 5. Procesar la respuesta
            $statusCode   = $response->getStatusCode();           // 200, 400, 500, etc.
            $responseBody = $response->getBody()->getContents();  // Texto JSON
            $jsonData     = json_decode($responseBody, true);

            // 6. Retornar la respuesta (JSON).
            //    Podrías también redirigir con session si prefieres.
            return response()->json([
                'status_code' => $statusCode,
                'data'        => $jsonData
            ], 200);

        } catch (\Exception $e) {
            // Manejo de excepciones (errores de red, timeouts, etc.)
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Consulta datos de una persona por DNI en RENIEC/PIDE.
     * Endpoint local: POST /estudiante/reniec/consultar
     */
    public function consultarDatos(Request $request)
    {
        // 1. Validar los campos necesarios
        $request->validate([
            'nuDniConsulta' => 'required|string', // DNI a consultar
            'nuDniUsuario'  => 'required|string', // Tu DNI (usuario)
            'nuRucUsuario'  => 'required|string', // RUC de la Entidad
            'password'      => 'required|string', // Credencial PIDE (la nueva)
        ]);

        // 2. Armar el body JSON
        $body = [
            'PIDE' => [
                'nuDniConsulta' => $request->input('nuDniConsulta'),
                'nuDniUsuario'  => $request->input('nuDniUsuario'),
                'nuRucUsuario'  => $request->input('nuRucUsuario'),
                'password'      => $request->input('password'),
            ]
        ];

        // 3. Cliente Guzzle
        $client = new Client([
            'base_uri' => env('PIDE_BASE_URL')
        ]);

        try {
            // 4. POST a "/Consultar?out=json"
            $response = $client->post('Consultar?out=json', [
                'headers' => [
                    'Content-Type' => 'application/json; charset=UTF-8',
                ],
                'json' => $body
            ]);

            // 5. Procesar la respuesta
            $statusCode   = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();
            $jsonData     = json_decode($responseBody, true);

            // 6. Devolver el resultado
            return response()->json([
                'status_code' => $statusCode,
                'data'        => $jsonData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
