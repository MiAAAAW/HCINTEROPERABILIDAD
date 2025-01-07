<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReniecService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://ws2.pide.gob.pe/Rest/RENIEC/';
    }

    /**
     * Actualizar la credencial en RENIEC.
     *
     * @param object $credentials
     * @param string $credencialAnterior
     * @param string $nuevaContraseña
     * @return array
     * @throws \Exception
     */
    public function actualizarCredencial($credentials, $credencialAnterior, $nuevaContraseña)
    {
        $url = $this->baseUrl . 'Actualizar?out=json';

        $payload = [
            'PIDE' => [
                'credencialAnterior' => $credencialAnterior,
                'credencialNueva' => $nuevaContraseña,
                'nuDni' => $credentials->dni,
                'nuRuc' => '20181438364', // RUC único
            ],
        ];

        Log::info('Enviando solicitud de actualización de credencial a RENIEC.', [
            'url' => $url,
            'payload' => $payload,
        ]);

        $response = Http::withHeaders(['Content-Type' => 'application/json; charset=UTF-8'])
            ->post($url, $payload);

        return $this->validateResponse($response, 'actualizar credencial');
    }

    /**
     * Consultar información de un DNI en RENIEC.
     *
     * @param string $dniConsulta
     * @param object $credentials
     * @return array
     * @throws \Exception
     */
    public function consultarDni($dniConsulta, $credentials)
    {
        $url = $this->baseUrl . 'Consultar?out=json';

        $payload = [
            'PIDE' => [
                'nuDniConsulta' => $dniConsulta,
                'nuDniUsuario' => $credentials->dni,
                'nuRucUsuario' => '20181438364', // RUC único
                'password' => $credentials->password,
            ],
        ];

        Log::info('Enviando solicitud de consulta de DNI a RENIEC.', [
            'url' => $url,
            'payload' => $payload,
        ]);

        $response = Http::withHeaders(['Content-Type' => 'application/json; charset=UTF-8'])
            ->post($url, $payload);

        return $this->validateResponse($response, 'consultar DNI');
    }

    /**
     * Validar la respuesta de RENIEC.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @param string $context
     * @return array
     * @throws \Exception
     */
    private function validateResponse($response, $context)
    {
        if ($response->failed()) {
            $data = $response->json();
            $code = $data['coResultado'] ?? null;
            $message = $data['deResultado'] ?? 'Error desconocido.';

            Log::error("Error en la operación de {$context}.", [
                'code' => $code,
                'message' => $message,
                'response' => $response->body(),
            ]);

            switch ($code) {
                case '1000':
                    throw new \Exception('Datos inválidos: ' . $message);
                case '1001':
                    throw new \Exception('Credenciales inválidas: ' . $message);
                case '1002':
                    throw new \Exception('Contraseña caducada: ' . $message);
                case '1003':
                    throw new \Exception('Límite de consultas alcanzado: ' . $message);
                default:
                    throw new \Exception('Error desconocido: ' . $message);
            }
        }

        Log::info("Operación de {$context} completada con éxito.", [
            'response' => $response->json(),
        ]);

        return $response->json();
    }
}
