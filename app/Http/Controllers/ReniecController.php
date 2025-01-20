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

        // 2. Preparar el cuerpo JSON para PIDE
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
            'base_uri' => env('PIDE_BASE_URL', 'https://ws2.pide.gob.pe/Rest/RENIEC/')
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
            $statusCode   = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();


            // 6. Intentar decodificar como JSON
            $jsonData = json_decode($responseBody, true);

            $coResultado = null;
            $deResultado = null;

            if (is_array($jsonData) && isset($jsonData['coResultado'])) {
                // Caso A: PIDE devolvió JSON con "coResultado"
                $coResultado = $jsonData['coResultado'] ?? null;
                $deResultado = $jsonData['deResultado'] ?? null;

            } else {
                // Caso B: Probablemente es XML (SOAP). Intentamos parsear manualmente
                // Verificamos que $jsonData es null o no tiene "coResultado"
                // Asumimos que $responseBody es XML
                $xml = @simplexml_load_string($responseBody);
                if ($xml !== false) {
                    // Buscar en la ruta "//return/coResultado" y "//return/deResultado"
                    // (puede variar según la estructura SOAP real)
                    $coResultNode = $xml->xpath('//return/coResultado');
                    $deResultNode = $xml->xpath('//return/deResultado');

                    $coResultado = isset($coResultNode[0]) ? (string)$coResultNode[0] : null;
                    $deResultado = isset($deResultNode[0]) ? (string)$deResultNode[0] : null;
                }
            }

            // 7. Retornar al Front
            // Aseguramos que data.coResultado y data.deResultado existan, aunque sean null
            return response()->json([
                'status_code' => $statusCode,
                'data' => [
                    'coResultado' => $coResultado,
                    'deResultado' => $deResultado,
                ]
            ], 200);

        } catch (\Exception $e) {
            // Manejo de excepciones (errores de red, timeouts, etc.)
            Log::error("ERROR actualizando credencial: ".$e->getMessage());
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
