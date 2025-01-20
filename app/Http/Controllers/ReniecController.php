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
            'base_uri' => env('PIDE_BASE_URL') // Por ej: "https://ws2.pide.gob.pe/Rest/RENIEC/"
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

            /**
             * Estructura típica devuelta por PIDE (ejemplo):
             * {
             *   "coResultado": "0000",
             *   "deResultado": "Actualización realizada correctamente"
             * }
             *
             * A veces puede variar, pero normalmente "coResultado" y "deResultado"
             * están en la raíz del JSON.
             */

            // Extraemos coResultado y deResultado
            $coResultado = $jsonData['coResultado'] ?? null;
            $deResultado = $jsonData['deResultado'] ?? null;

            /**
             * Si deseas usar un status HTTP 200 siempre, basta con hacer:
             *   $finalStatus = 200;
             *
             * Pero si quieres marcar un error cuando coResultado != '0000', podrías hacer:
             */
            $finalStatus = ($coResultado === '0000') ? 200 : 400;

            // 6. Retornar la respuesta con la ESTRUCTURA unificada
            return response()->json([
                'status_code' => $finalStatus,
                'data'        => [
                    'coResultado' => $coResultado,
                    'deResultado' => $deResultado,
                ],
                // Si deseas ver la respuesta completa que vino de PIDE, podrías incluirla aquí:
                // 'raw_pide'     => $jsonData,
            ], $finalStatus);

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
