<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\UserCredential;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';

        if (Auth::user()->user_type == 1) {
            return view('admin.dashboard', $data);
        } elseif (Auth::user()->user_type == 2) {
            return view('docente.dashboard', $data);
        } elseif (Auth::user()->user_type == 3) {
            // Obtener las credenciales del estudiante (si existen)
            $credentials = UserCredential::where('user_id', Auth::id())->first();
            $data['credentials'] = $credentials;

            return view('estudiante.dashboard', $data);
        }
    }

    // Guarda o actualiza las credenciales del usuario
    public function storeCredentials(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|string|size:8',
            'ruc' => 'required|string',
            'password' => 'required|string',
        ]);

        UserCredential::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'dni' => $validated['dni'],
                'ruc' => $validated['ruc'],
                'password' => bcrypt($validated['password']), // Encriptar la contraseña
                'last_updated_at' => now(),
            ]
        );

        return back()->with('success', 'Credenciales guardadas correctamente.');
    }

    // Procesa la consulta de DNI usando el servicio de RENIEC
    public function processConsultaDni(Request $request)
    {
        $validated = $request->validate([
            'dni_consulta' => 'required|string|size:8',
        ]);

        // Obtener credenciales del usuario actual
        $credentials = UserCredential::where('user_id', Auth::id())->first();

        if (!$credentials) {
            return back()->withErrors(['msg' => 'Primero debe guardar sus credenciales.']);
        }

        $url = 'https://ws2.pide.gob.pe/Rest/RENIEC/Consultar?out=json';
        $payload = [
            'PIDE' => [
                'nuDniConsulta' => $validated['dni_consulta'],
                'nuDniUsuario' => $credentials->dni,
                'nuRucUsuario' => $credentials->ruc,
                'password' => $credentials->password,
            ],
        ];

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json; charset=UTF-8'])
                ->post($url, $payload);

            if ($response->successful()) {
                return redirect()
                    ->route('estudiante.dashboard')
                    ->with('data', $response->json());
            }

            return back()->withErrors(['msg' => 'Error en la consulta: ' . $response->status()]);
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error: ' . $e->getMessage()]);
        }
    }
}
