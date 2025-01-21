<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InscribirModel;
use SoapClient;
use GuzzleHttp\Client;
use Exception;

class RucController extends Controller
{
    public function ruc()
    {
        return view('estudiante.ruc');
    }

}

class SunatController extends Controller
{
    private $soapUrl;
    private $restBaseUrl;

    public function __construct()
    {
        $this->soapUrl = env('SUNAT_SOAP_URL', 'https://ws3.pide.gob.pe/services/SunatConsultaRuc?wsdl');
        $this->restBaseUrl = env('SUNAT_REST_BASE_URL', 'https://ws3.pide.gob.pe/Rest/Sunat/');
    }

    /**
     * SOAP Methods
     */
    public function getDatosPrincipales(Request $request)
    {
        return $this->soapRequest('getDatosPrincipales', ['numruc' => $request->input('numruc')]);
    }

    public function getDatosSecundarios(Request $request)
    {
        return $this->soapRequest('getDatosSecundarios', ['numruc' => $request->input('numruc')]);
    }

    public function getDatosT1144(Request $request)
    {
        return $this->soapRequest('getDatosT1144', ['numruc' => $request->input('numruc')]);
    }

    public function getDatosT362(Request $request)
    {
        return $this->soapRequest('getDatosT362', ['numruc' => $request->input('numruc')]);
    }

    public function getDomicilioLegal(Request $request)
    {
        return $this->soapRequest('getDomicilioLegal', ['numruc' => $request->input('numruc')]);
    }

    public function getEstablecimientosAnexos(Request $request)
    {
        return $this->soapRequest('getEstablecimientosAnexos', ['numruc' => $request->input('numruc')]);
    }

    public function getEstAnexosT1150(Request $request)
    {
        return $this->soapRequest('getEstAnexosT1150', ['numruc' => $request->input('numruc')]);
    }

    public function getRepLegales(Request $request)
    {
        return $this->soapRequest('getRepLegales', ['numruc' => $request->input('numruc')]);
    }

    public function buscarRazonSocial(Request $request)
    {
        return $this->soapRequest('buscarRazonSocial', ['razonSocial' => $request->input('razon_social')]);
    }

    private function soapRequest($operation, $params)
    {
        try {
            $client = new SoapClient($this->soapUrl);
            $response = $client->__soapCall($operation, [$params]);
            return response()->json($response);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * REST Methods
     */
    public function getDatosViaREST(Request $request)
    {
        $ruc = $request->input('numruc');
        $methods = [
            'DatosPrincipales',
            'DatosSecundarios',
            'DomicilioLegal',
            'EstablecimientosAnexos',
            'RepLegales'
        ];

        $results = [];
        $client = new Client(['base_uri' => $this->restBaseUrl]);

        foreach ($methods as $method) {
            try {
                $response = $client->get($method, [
                    'query' => ['numruc' => $ruc],
                    'headers' => ['Accept' => 'application/json']
                ]);
                $results[$method] = json_decode($response->getBody(), true);
            } catch (Exception $e) {
                $results[$method] = ['error' => $e->getMessage()];
            }
        }

        return response()->json($results);
    }

    /**
     * Combined Method to Extract All Data for the View
     */
    public function getAllData(Request $request)
    {
        $ruc = $request->input('numruc');
        $soapMethods = [
            'getDatosPrincipales',
            'getDatosSecundarios',
            'getDatosT1144',
            'getDatosT362',
            'getDomicilioLegal',
            'getEstablecimientosAnexos',
            'getEstAnexosT1150',
            'getRepLegales',
            'buscarRazonSocial'
        ];

        $results = [
            'soap' => [],
            'rest' => []
        ];

        // Fetch SOAP data
        foreach ($soapMethods as $method) {
            $results['soap'][$method] = $this->soapRequest($method, ['numruc' => $ruc])->original;
        }

        // Fetch REST data
        $restResults = $this->getDatosViaREST($request)->original;
        $results['rest'] = $restResults;

        return view('estudiante.ruc_resultados', ['data' => $results]);
    }
}

