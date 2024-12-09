<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CursosModel;

class CursosController extends Controller
{
    public function list()
    {
        $data['getRecord'] = CursosModel::getRecord();
        $data['header_title'] = "Cursos";
        return view('admin.cursos.list', $data);
    }

    public function add()
    {
        $data['header_title'] = "Agregar Cursos ";
        return view('admin.cursos.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'cod' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'mension' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required|integer',
        ]);

        $save = new CursosModel;
        $save->cod = trim($request->cod);
        $save->name = trim($request->name);
        $save->mension = trim($request->mension);
        $save->type = trim($request->type);
        $save->status = trim($request->status);
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect('admin/cursos/list')->with('success', "Curso Creado");
    }

    public function edit($id)
    {
        $data['getRecord'] = CursosModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Editar Curso ";
            return view('admin.cursos.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'cod' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'mension' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required|integer',
        ]);

        $save = CursosModel::getSingle($id);
        $save->cod = trim($request->cod);
        $save->name = trim($request->name);
        $save->mension = trim($request->mension);
        $save->type = trim($request->type);
        $save->status = trim($request->status);
        $save->save();

        return redirect('admin/cursos/list')->with('success', "Curso Actualizado");
    }

    public function delete($id)
    {
        $save = CursosModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', "Curso Borrado");
    }
}