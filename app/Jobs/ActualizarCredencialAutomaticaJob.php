<?php

namespace App\Jobs;

use App\Models\UserCredential;
use App\Services\ReniecService;
use Illuminate\Support\Facades\Log;

class ActualizarCredencialAutomaticaJob
{
    public function handle()
    {
        $credentials = UserCredential::all();

        foreach ($credentials as $credential) {
            if ($credential->isPasswordExpired()) {
                $nuevaCredencial = $this->generarContrasenaSegura();

                try {
                    app(ReniecService::class)->actualizarCredencial(
                        $credential,
                        $credential->password,
                        $nuevaCredencial
                    );

                    $credential->update([
                        'password' => bcrypt($nuevaCredencial),
                        'last_updated_at' => now(),
                    ]);

                    Log::info("Credencial actualizada automáticamente para el usuario {$credential->user_id}.");
                } catch (\Exception $e) {
                    Log::error("Error actualizando credencial para usuario {$credential->user_id}: {$e->getMessage()}");
                }
            }
        }
    }

    private function generarContrasenaSegura()
    {
        // Genera una contraseña segura con letras mayúsculas, minúsculas y números
        $longitud = 8; // Puedes ajustar la longitud si es necesario
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $contraseña = '';

        for ($i = 0; $i < $longitud; $i++) {
            $contraseña .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }

        return $contraseña;
    }
}
