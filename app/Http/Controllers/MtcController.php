<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class MtcController extends Controller
{
    public function mostrarFormulario()
    {
        return view('estudiante.mtc');
    }

    public function consultarTodo(Request $request)
    {
        $dni = $request->input('dni');
        $tipo = $request->input('tipo');

        // 1. Última Licencia
        $licenciaResponse = Http::get(env('PIDE_PROXY_URL') . '/UltimaLicencia', [
            'iTipoDocumento' => 2,
            'sNumDocumento' => $dni,
            'out' => 'json'
        ]);
        $licenciaData = $licenciaResponse->json();

        // 2. Papeletas
        $papeletasResponse = Http::get(env('PIDE_PROXY_URL') . '/DatosPapeletas', [
            'iTipoDocumento' => 2,
            'sNumDocumento' => $dni,
            'out' => 'json'
        ]);
        $papeletasData = $papeletasResponse->json();

        // 3. Sanciones
        $sancionesResponse = Http::get(env('PIDE_PROXY_URL') . '/UltimasSanciones', [
            'iTipoDocumento' => 2,
            'sNumDocumento' => $dni,
            'out' => 'json'
        ]);
        $sancionesData = $sancionesResponse->json();

        return view('estudiante.mtc', compact('dni', 'tipo', 'licenciaData', 'papeletasData', 'sancionesData'));
    }

    public function exportarPDF(Request $request)
    {
        $tipo = $request->input('tipo');
        $dni = $request->input('dni');

        // Obtener datos desde la API
        $licenciaData = Http::get(env('PIDE_PROXY_URL') . '/UltimaLicencia', [
            'iTipoDocumento' => $tipo,
            'sNumDocumento' => $dni,
            'out' => 'json'
        ])->json();

        $papeletasData = Http::get(env('PIDE_PROXY_URL') . '/DatosPapeletas', [
            'iTipoDocumento' => $tipo,
            'sNumDocumento' => $dni,
            'out' => 'json'
        ])->json();

        $sancionesData = Http::get(env('PIDE_PROXY_URL') . '/UltimasSanciones', [
            'iTipoDocumento' => $tipo,
            'sNumDocumento' => $dni,
            'out' => 'json'
        ])->json();

        return Pdf::loadView('estudiante.mtc_pdf', compact(
            'licenciaData', 'papeletasData', 'sancionesData', 'dni', 'tipo'
        ))->download('record_conductor_' . $dni . '.pdf');
    }
}
