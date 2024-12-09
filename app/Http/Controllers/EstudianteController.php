<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EstudianteController extends Controller
{
    public function list() 
    {    
      $data['getRecord'] = User::getEstudiante(); 
      $data['header_title'] = "Lista de Estudiantes";
      return view('admin.estudiante.list', $data);
    }

    public function add() 
    {    
      $data['header_title'] = "Agregar Estudiantes";
      return view('admin.estudiante.add', $data);
    }
    

    public function insert(Request $request) 
    {    
        request()->validate([
            'email' => 'nullable|email|regex:/^[\pL\pN._%+-]+@[\pL\pNñÑ.-]+\.[a-z]{2,6}$/iu|unique:users,email',
            //'dni' => 'required|unique:users',
            'codigo' => 'required|unique:users',
        ]);
    
        $estudiante = new User;
        $estudiante->name = trim($request->name);
        $estudiante->last_name = trim($request->last_name);
        $estudiante->dni = trim($request->dni);
        $estudiante->email = trim($request->email);
        $estudiante->codigo = trim($request->codigo);
        $estudiante->password = Hash::make($request->password);
        $estudiante->user_type = 3;
        $estudiante->save();   
            
        return redirect('admin/estudiante/list')->with('success', 'Estudiante correctamente creado');
    }
    
    public function edit($id) 
    {
        $estudiante = User::getSingle($id);
        if ($estudiante) {
            $data['estudiante'] = $estudiante;
            $data['header_title'] = "Editar Estudiante";
            return view('admin.estudiante.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        request()->validate([
            'email' => 'nullable|email|regex:/^[\pL\pN._%+-]+@[\pL\pNñÑ.-]+\.[a-z]{2,6}$/iu|unique:users,email,' . $id,
            //'dni' => 'required|unique:users,dni,' . $id,
            'codigo' => 'required|unique:users,codigo,' . $id,
        ]);

        $estudiante = User::getSingle($id);
        $estudiante->name = trim($request->name);
        $estudiante->last_name = trim($request->last_name);
        $estudiante->dni = trim($request->dni);  
        $estudiante->email = trim($request->email);
        $estudiante->codigo = trim($request->codigo);

        if (!empty($request->password)) {
            $estudiante->password = Hash::make($request->password);
        }

        $estudiante->save();

        return redirect('admin/estudiante/list')->with('success', 'Estudiante correctamente actualizado');
    }

    public function delete($id)
    {
        $user = User::getSingle($id); 
        if ($user) {
            $user->delete();
            return redirect('admin/estudiante/list')->with('success', 'Estudiante correctamente borrado');
        } else {
            return redirect('admin/estudiante/list')->with('error', 'Estudiante no encontrado');
        }
    }
}