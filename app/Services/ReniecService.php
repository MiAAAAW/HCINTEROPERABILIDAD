<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ReniecService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://ws2.pide.gob.pe/Rest/RENIEC/';
    }

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

        $response = Http::withHeaders(['Content-Type' => 'application/json; charset=UTF-8'])
            ->post($url, $payload);

        return $this->validateResponse($response);
    }

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

        $response = Http::withHeaders(['Content-Type' => 'application/json; charset=UTF-8'])
            ->post($url, $payload);

        return $this->validateResponse($response);
    }


    private function validateResponse($response)
    {
        if ($response->failed()) {
            $data = $response->json();
            $code = $data['coResultado'] ?? null;
            $message = $data['deResultado'] ?? 'Error desconocido.';

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

        return $response->json();
    }
}
