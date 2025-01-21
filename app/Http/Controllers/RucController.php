<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
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

    // Procesar consulta según el servicio seleccionado
    public function consultar(Request $request)
    {
        $ruc = $request->input('ruc');
        $service = $request->input('service');

        if (!$ruc) {
            return back()->withErrors(['El número de RUC es obligatorio.']);
        }

        // Determinar el endpoint y realizar la consulta
        switch ($service) {
            case 'getDatosPrincipales':
                $endpoint = "DatosPrincipales";
                break;
            case 'getDatosSecundarios':
                $endpoint = "DatosSecundarios";
                break;
            case 'getDomicilioLegal':
                $endpoint = "DomicilioLegal";
                break;
            case 'getEstablecimientosAnexos':
                $endpoint = "EstablecimientosAnexos";
                break;
            default:
                return back()->withErrors(['Servicio no válido.']);
        }

        $result = $this->consumeService($endpoint, ['numruc' => $ruc, 'out' => 'json']);

        if (isset($result['error']) && $result['error'] === true) {
            return back()->withErrors([$result['message']]);
        }

        return view('estudiante.ruc', ['result' => $result, 'ruc' => $ruc, 'service' => $service]);
    }
}
