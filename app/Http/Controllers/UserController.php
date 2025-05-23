<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function change_password()
    {
        $data['header_title'] = "Cambiar Contraseña";
        return view('profile.change_password', $data);

    }

    public function update_change_password(Request $request)
    {
        //dd($request->all());
        $user = User::getSingle(Auth::user()->id);
        if(Hash::check($request->old_password, $user->password))
        {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', "Contraseña correctamente Actualziada");
        }
        else
        {
            return redirect()->back()->with('error', "Contraseña actual incorrecta");

        }
    }
}
