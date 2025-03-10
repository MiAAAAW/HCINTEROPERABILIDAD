<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MinjusController extends Controller
{
    protected $baseUrl;
    protected $timeout;

    public function __construct()
    {
        // URL base del servicio REST según el manual MINJUS
        $this->baseUrl = 'https://ws4.pide.gob.pe/Rest/MinJus/';
        $this->timeout = 10; // Tiempo de espera en segundos
    }

    // Muestra la vista única con el formulario completo
    public function index()
    {
        return view('estudiante.minjus');
    }

    // Método que recoge todas las entradas (credenciales y parámetros opcionales)
    // y consulta cada endpoint REST de forma automática.
    public function consultAll(Request $request)
    {
        // Se recogen las credenciales (obligatorias)
        $user = $request->input('user');
        $pass = $request->input('pass');
        if (empty($user) || empty($pass)) {
            return back()->with('error', 'Debe ingresar usuario y contraseña proporcionados por MINJUS.');
        }

        // Parámetros opcionales para las consultas
        $colegioId       = $request->input('colegioId');
        $colegiatura     = $request->input('colegiatura');
        $tipoDocumento   = $request->input('tipoDocumento');
        $numeroDocumento = $request->input('numeroDocumento');
        $apePaterno      = $request->input('apePaterno');
        $apeMaterno      = $request->input('apeMaterno');
        $nombres         = $request->input('nombres');
        $recuperarArchivo= $request->input('recuperarArchivo', 'false');

        // Se crea el cliente Guzzle
        $client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => $this->timeout,
            'verify'   => false,
        ]);

        // Método auxiliar inline para realizar peticiones POST y decodificar JSON
        $postJson = function ($endpoint, array $payload) use ($client) {
            try {
                $response = $client->post($endpoint . '?out=json', [
                    'json' => $payload,
                ]);
                return json_decode($response->getBody(), true);
            } catch (RequestException $e) {
                return ['error' => $e->getMessage()];
            }
        };

        // Se preparan las consultas
        $responses = [];

        // 1. ColegioAbogado
        $responses['ColegioAbogado'] = $postJson('ColegioAbogado', [
            'PIDE' => [
                'user' => $user,
                'pass' => $pass,
            ],
        ]);

        // 2. EntidadSancionadora
        $responses['EntidadSancionadora'] = $postJson('EntidadSancionadora', [
            'PIDE' => [
                'user' => $user,
                'pass' => $pass,
            ],
        ]);

        // 3. SancionColegiatura
        $responses['SancionColegiatura'] = $postJson('SancionColegiatura', [
            'PIDE' => [
                'user'             => $user,
                'pass'             => $pass,
                'colegioId'        => $colegioId,
                'colegiatura'      => $colegiatura,
                'recuperarArchivo' => $recuperarArchivo,
            ],
        ]);

        // 4. SancionDocumento
        $responses['SancionDocumento'] = $postJson('SancionDocumento', [
            'PIDE' => [
                'user'            => $user,
                'pass'            => $pass,
                'tipoDocumento'   => $tipoDocumento,
                'numeroDocumento' => $numeroDocumento,
                'recuperarArchivo'=> $recuperarArchivo,
            ],
        ]);

        // 5. SancionNombre
        $responses['SancionNombre'] = $postJson('SancionNombre', [
            'PIDE' => [
                'user'           => $user,
                'pass'           => $pass,
                'apePaterno'     => $apePaterno,
                'apeMaterno'     => $apeMaterno,
                'nombres'        => $nombres,
                'recuperarArchivo'=> $recuperarArchivo,
            ],
        ]);

        // 6. TipoDocumento
        $responses['TipoDocumento'] = $postJson('TipoDocumento', [
            'PIDE' => [
                'user' => $user,
                'pass' => $pass,
            ],
        ]);

        // 7. TipoSanciones
        $responses['TipoSanciones'] = $postJson('TipoSanciones', [
            'PIDE' => [
                'user' => $user,
                'pass' => $pass,
            ],
        ]);

        // Retornamos la vista con las respuestas en sesión
        return back()->with([
            'allResponses' => $responses,
            'endpointName' => 'Todas las Funciones'
        ]);
    }
}
