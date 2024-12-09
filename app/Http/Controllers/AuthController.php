<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check())
        {
            switch (Auth::user()->user_type)
            {
                case 1:
                    // return redirect('admin/admin/list');
                    return redirect('admin/dashboard');
                case 2:
                    return redirect('docente/dashboard');
                case 3:
                    //return redirect('estudiante/notas');
                    return redirect('estudiante/dashboard');
                default:
                    Auth::logout();
                    return redirect('login')->with('error', 'Tipo de usuario no reconocido');
            }
        }

        return view('auth.login');
    }

    public function AuthLogin(Request $request)
    {
        $remember = $request->has('remember');
        $credentials = $request->only('password');
        $login = $request->input('login');

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $login;
        } else {
            $credentials['codigo'] = $login;
        }

        // Obtener el usuario usando email o código
        $user = User::where('email', $login)->orWhere('codigo', $login)->first();

        if ($user) {
            // Verificar si la contraseña está hasheada con SHA1
            if (strlen($user->password) == 40 && hash_equals(sha1($request->password), $user->password)) {
                // Actualizar a bcrypt
                $user->password = Hash::make($request->password);
                $user->save();
            }

            // Intentar autenticar con la contraseña actualizada o bcrypt
            $credentials = [
                'email' => $user->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials, $remember)) {
                switch (Auth::user()->user_type) {
                    case 1:
                        //return redirect('admin/admin/list');
                        return redirect('admin/dashboard');
                    case 2:
                        return redirect('docente/dashboard');
                    case 3:
                        //return redirect('estudiante/notas');
                        return redirect('estudiante/dashboard');
                    default:
                        Auth::logout();
                        return redirect('login')->with('error', 'Tipo de usuario no reconocido');
                }
            }
        }

        return redirect()->back()->with('error', 'Ingrese email/código y/o password correcto');
    }

    public function forgotpassword()
    {
        return view('auth.forgot');
    }

    public function PostForgotPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user)
        {
            $user->remember_token = Str::random(60);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success', "Revise su correo y reinicie la contraseña");
        }
        else
        {
            return redirect()->back()->with('error', "Cuenta no encontrada.");
        }
    }

    public function reset($remember_token)
    {
        $user = User::where('remember_token', $remember_token)->first();
        if ($user)
        {
            $data['user'] = $user;
            return view('auth.reset', $data);
        }
        else
        {
            abort(404);
        }
    }

    public function PostReset($token, Request $request)
    {
        if ($request->password === $request->cpassword)
        {
            $user = User::where('remember_token', $token)->first();
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();

            return redirect('login')->with('success', "Contraseña correctamente reiniciada");
        }
        else
        {
            return redirect()->back()->with('error', "Las contraseñas no coinciden");
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}



