<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InscribirModel;

class EstudianteNotasController extends Controller
{
    public function notas(Request $request)
    {
        $userId = Auth::id(); // Obtener el ID del usuario autenticado
        $notas = InscribirModel::with(['periodoCurso.curso', 'periodoCurso.periodo'])
            ->where('user_id', $userId)
            ->get();

        return view('estudiante.notas', ['notas' => $notas]);
    }
}