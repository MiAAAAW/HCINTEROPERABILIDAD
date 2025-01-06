<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCredential;
use App\Services\ReniecService;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';

        if (Auth::user()->user_type == 1) {
            return view('admin.dashboard', $data); // Redirigir al dashboard del administrador
        } elseif (Auth::user()->user_type == 2) {
            return view('docente.dashboard', $data); // Redirigir al dashboard del docente
        } elseif (Auth::user()->user_type == 3) {
            // Obtener credenciales del estudiante
            $credentials = UserCredential::where('user_id', Auth::id())->first();
            $data['credentials'] = $credentials;

            return view('estudiante.dashboard', $data); // Redirigir al dashboard del estudiante
        }

        abort(403, 'No tiene acceso a esta sección.'); // Manejar accesos no autorizados
    }

    public function configurarCredenciales(Request $request, ReniecService $reniecService)
    {
        $validated = $request->validate([
            'credencial_actual' => 'required|string',
            'nueva_credencial' => 'required|string|min:8',
        ]);
    
        $credentials = UserCredential::where('user_id', auth()->id())->firstOrFail();
    
        try {
            // Llamar al servicio REST para actualizar la credencial
            $reniecService->actualizarCredencial(
                $credentials,
                $validated['credencial_actual'],
                $validated['nueva_credencial']
            );
    
            // Guardar la nueva credencial en la base de datos
            $credentials->update([
                'password' => bcrypt($validated['nueva_credencial']),
                'last_updated_at' => now(),
            ]);
    
            return back()->with('success', 'Credencial inicial actualizada correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error al actualizar credencial: ' . $e->getMessage()]);
        }
    }

    public function renovarCredencialManual(Request $request, ReniecService $reniecService)
    {
        $credentials = UserCredential::where('user_id', auth()->id())->firstOrFail();

        $nuevaCredencial = 'Clave' . rand(1000, 9999);

        try {
            $reniecService->actualizarCredencial($credentials, $credentials->password, $nuevaCredencial);

            $credentials->update([
                'password' => bcrypt($nuevaCredencial),
                'last_updated_at' => now(),
            ]);

            return back()->with('success', 'Credencial renovada manualmente.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function processConsultaDni(Request $request, ReniecService $reniecService)
    {
        $validated = $request->validate([
            'dni_consulta' => 'required|string|size:8',
        ]);

        $credentials = UserCredential::where('user_id', auth()->id())->firstOrFail();

        try {
            $data = $reniecService->consultarDni($validated['dni_consulta'], $credentials);
            return back()->with('data', $data);
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $e->getMessage()]);
        }
    }
}

