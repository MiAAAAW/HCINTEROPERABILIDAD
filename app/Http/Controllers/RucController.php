<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InscribirModel;

class RucController extends Controller
{
    public function ruc()
    {
        return view('estudiante.ruc');
    }

}
