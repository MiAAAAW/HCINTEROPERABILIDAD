<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;


class ReniecController extends Controller
{
    /**
     * Actualiza la credencial (contraseña) del usuario en RENIEC/PIDE.
     * Endpoint local: POST /estudiante/reniec/actualizar
     */
    public function actualizarCredencial(Request $request)
    {
        $request->validate([
            'credencialAnterior' => 'required|string',
            'credencialNueva'    => 'required|string',
            'nuDni'              => 'required|string',
            'nuRuc'              => 'required|string',
        ]);

        $body = [
            'PIDE' => [
                'credencialAnterior' => $request->credencialAnterior,
                'credencialNueva'    => $request->credencialNueva,
                'nuDni'              => $request->nuDni,
                'nuRuc'              => $request->nuRuc,
            ]
        ];

        $client = new \GuzzleHttp\Client([
            'base_uri' => env('PIDE_BASE_URL', 'https://ws2.pide.gob.pe/Rest/RENIEC/'),
        ]);

        try {
            $response = $client->post('Actualizar?out=json', [
                'headers' => [ 'Content-Type' => 'application/json; charset=UTF-8' ],
                'json'    => $body
            ]);

            $statusCode   = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            // 1. Loguear la respuesta cruda
            Log::info("[DEBUG] Respuesta cruda PIDE (Actualizar): ".$responseBody);

            // 2. Dump & Die para ver en el navegador la respuesta cruda (opcional)
            //    Esto detendrá la ejecución y te mostrará la respuesta en pantalla.
            // dd($responseBody);

            // 3. Intentar parsear como JSON
            $jsonData = json_decode($responseBody, true);

            // 4. Loguear el resultado de json_decode
            Log::info("[DEBUG] jsonData parseado: ".print_r($jsonData, true));

            // [Aquí tu lógica normal]
            // Ejemplo:
            $coResultado = $jsonData['coResultado'] ?? null;
            $deResultado = $jsonData['deResultado'] ?? null;

            // Retorno de ejemplo:
            return response()->json([
                'data' => [
                    'coResultado' => $coResultado,
                    'deResultado' => $deResultado
                ]
            ], 200);

        } catch (\Exception $e) {
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

            /**
             * Estructura típica de la respuesta de PIDE en Consultar:
             * {
             *   "consultarResponse": {
             *     "return": {
             *       "coResultado": "0000",
             *       "deResultado": "Consulta realizada correctamente",
             *       "datosPersona": {
             *           "apPrimer": "...",
             *           "apSegundo": "...",
             *           ...
             *       }
             *     }
             *   }
             * }
             *
             * coResultado suele estar dentro de "consultarResponse.return.coResultado"
             */

            // Extraemos coResultado y deResultado (si existen)
            $coResultado = null;
            $deResultado = null;
            if (isset($jsonData['consultarResponse']['return'])) {
                $retorno     = $jsonData['consultarResponse']['return'];
                $coResultado = $retorno['coResultado'] ?? null;
                $deResultado = $retorno['deResultado'] ?? null;
            }

            // Podrías decidir tu status final:
            $finalStatus = ($coResultado === '0000') ? 200 : 400;

            // 6. Devolver la respuesta, anidando coResultado y deResultado en 'data'
            return response()->json([
                'status_code' => $finalStatus,
                'data'        => [
                    'coResultado'       => $coResultado,
                    'deResultado'       => $deResultado,
                    // Incluimos toda la estructura 'consultarResponse' para que el front la use
                    'consultarResponse' => $jsonData['consultarResponse'] ?? null,
                ],
                // 'raw_pide' => $jsonData, // si quieres ver la respuesta cruda
            ], $finalStatus);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
