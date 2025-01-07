<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\UserCredential;
use App\Services\ReniecService;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';

        if (Auth::user()->user_type == 1) {
            return view('admin.dashboard', $data); // Dashboard del administrador
        } elseif (Auth::user()->user_type == 2) {
            return view('docente.dashboard', $data); // Dashboard del docente
        } elseif (Auth::user()->user_type == 3) {
            // Obtener credenciales del estudiante
            $credentials = UserCredential::where('user_id', Auth::id())->first();
            $data['credentials'] = $credentials;

            return view('estudiante.dashboard', $data); // Dashboard del estudiante
        }

        abort(403, 'No tiene acceso a esta sección.'); // Manejar accesos no autorizados
    }

    /**
     * Configurar credenciales iniciales para RENIEC.
     */
    public function configurarCredenciales(Request $request, ReniecService $reniecService)
    {
        // Validar los datos ingresados por el usuario
        $validated = $request->validate([
            'credencial_actual' => 'required|string',
            'nueva_credencial' => 'required|string|min:8',
        ]);
    
        // Obtener las credenciales del usuario autenticado
        $credentials = UserCredential::where('user_id', auth()->id())->first();
    
        if (!$credentials) {
            return back()->withErrors(['msg' => 'No se encontraron credenciales para este usuario.']);
        }
    
        try {
            // Llamar al servicio REST para actualizar la credencial en RENIEC
            $reniecService->actualizarCredencial(
                $credentials, // Objeto de credenciales
                $validated['credencial_actual'], // Credencial inicial
                $validated['nueva_credencial'] // Nueva credencial
            );
    
            // Actualizar la credencial en la base de datos
            $credentials->update([
                'password' => bcrypt($validated['nueva_credencial']),
                'last_updated_at' => now(),
            ]);
    
            return back()->with('success', 'Credencial configurada correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error al configurar credencial: ' . $e->getMessage()]);
        }
    }
    

    /**
     * Renovar credencial manualmente.
     */
    public function renovarCredencialManual(Request $request, ReniecService $reniecService)
    {
        $credentials = UserCredential::where('user_id', auth()->id())->firstOrFail();

        if ($credentials->isPasswordExpired()) {
            $nuevaCredencial = 'Clave' . rand(1000, 9999);

            try {
                // Actualizar credencial en RENIEC
                $reniecService->actualizarCredencial(
                    $credentials->dni,
                    $credentials->password,
                    $nuevaCredencial,
                    $credentials->ruc
                );

                // Actualizar en la base de datos
                $credentials->update([
                    'password' => $nuevaCredencial, // Se cifrará automáticamente
                    'last_updated_at' => now(),
                ]);

                return back()->with('success', 'Credencial renovada manualmente.');
            } catch (\Exception $e) {
                return back()->withErrors(['msg' => 'Error al renovar credencial: ' . $e->getMessage()]);
            }
        }

        return back()->with('info', 'La credencial aún no ha caducado.');
    }

    /**
     * Consultar información de un DNI.
     */
    public function processConsultaDni(Request $request, ReniecService $reniecService)
    {
        $validated = $request->validate([
            'dni_consulta' => 'required|string|size:8',
        ]);

        $credentials = UserCredential::where('user_id', auth()->id())->firstOrFail();

        try {
            // Consultar información del DNI
            $data = $reniecService->consultarDni(
                $validated['dni_consulta'],
                $credentials->dni,
                $credentials->password,
                $credentials->ruc
            );

            return back()->with('data', $data);
        } catch (\Exception $e) {
            Log::error('Error al consultar DNI: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Error al consultar DNI: ' . $e->getMessage()]);
        }
    }
}
