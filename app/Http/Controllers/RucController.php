<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;

class RucController extends Controller
{
    private $baseUrl = "https://ws3.pide.gob.pe/Rest/Sunat/";

    // Método genérico para consumir el servicio REST
    private function consumeService($endpoint, $params = [])
    {
        try {
            $client = new Client();
            $response = $client->get($this->baseUrl . $endpoint, ['query' => $params]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents(), true);
            }

            return [
                'error' => true,
                'message' => 'Error al consultar el servicio REST.',
                'status' => $response->getStatusCode()
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => 'Error al conectar con el servicio: ' . $e->getMessage()
            ];
        }
    }

    // Mostrar vista del formulario
    public function ruc()
    {
        return view('estudiante.ruc');
    }

    // Consultar todos los servicios
    public function consultar(Request $request)
    {
        $ruc = $request->input('ruc');

        if (!$ruc) {
            return back()->withErrors(['El número de RUC es obligatorio.']);
        }

        // Ejecutar todas las consultas
        $results = [
            'DatosPrincipales' => $this->consumeService("DatosPrincipales", ['numruc' => $ruc, 'out' => 'json']),
            'DatosSecundarios' => $this->consumeService("DatosSecundarios", ['numruc' => $ruc, 'out' => 'json']),
            'DomicilioLegal' => $this->consumeService("DomicilioLegal", ['numruc' => $ruc, 'out' => 'json']),
            'EstablecimientosAnexos' => $this->consumeService("EstablecimientosAnexos", ['numruc' => $ruc, 'out' => 'json']),
        ];

        return view('estudiante.ruc', ['results' => $results, 'ruc' => $ruc]);
    }
}
