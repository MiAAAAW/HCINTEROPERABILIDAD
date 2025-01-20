<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ReniecController extends Controller
{
    public function actualizarCredencial(Request $request)
    {
        // 1. Validar
        $request->validate([
            'credencialAnterior' => 'required|string',
            'credencialNueva'    => 'required|string',
            'nuDni'              => 'required|string',
            'nuRuc'              => 'required|string',
        ]);

        // 2. Construir el body JSON para PIDE
        $body = [
            'PIDE' => [
                'credencialAnterior' => $request->input('credencialAnterior'),
                'credencialNueva'    => $request->input('credencialNueva'),
                'nuDni'              => $request->input('nuDni'),
                'nuRuc'              => $request->input('nuRuc'),
            ]
        ];

        // 3. Guzzle Client
        $client = new Client([
            'base_uri' => env('PIDE_BASE_URL', 'https://ws2.pide.gob.pe/Rest/RENIEC/')
        ]);

        try {
            // 4. Consumir "/Actualizar?out=json"
            $response = $client->post('Actualizar?out=json', [
                'headers' => [
                    'Content-Type' => 'application/json; charset=UTF-8',
                ],
                'json' => $body
            ]);

            $statusCode   = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            // ============= DEPURACIÓN CRUCIAL =============
            // 1) VER TEXTO CRUDO (JSON, SOAP, etc.) en el navegador
            dd($responseBody);

            /*
            // OPCIONAL: si no quieres detener la ejecución, usa Log::info:
            \Log::info("[DEBUG] Respuesta Cruda de PIDE (Actualizar): ".$responseBody);

            // 2) Intentar parsear JSON
            $jsonData = json_decode($responseBody, true);

            // 3) Retornar lo mismo para que tu front reciba todo
            return response()->json([
                'status_code' => $statusCode,
                'raw_pide'    => $responseBody,
                'json_decoded'=> $jsonData
            ], 200);
            */

        } catch (\Exception $e) {
            // Manejo de excepciones (errores de conexión, timeouts, etc.)
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
