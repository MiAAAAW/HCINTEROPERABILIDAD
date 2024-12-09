<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PeriodoModel;

class PeriodoController extends Controller
{
    public function list()
    {
        $data['getRecord'] = PeriodoModel::getRecord();

        $data['header_title'] = "Periodos";
        return view('admin.periodo.list', $data);
    }

    public function add()
    {
        $data['header_title'] = "Agregar Periodo ";
        return view('admin.periodo.add', $data);
    }

    public function insert(Request $request)
    {
        $save = new PeriodoModel;
        $save->name = $request->name;
        $save->status = $request->status;
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect('admin/periodo/list')->with('success', "Creado Correctamente");
    }

    public function edit($id)
    {
        $data['getRecord'] = PeriodoModel::getSingle($id);
        if(!empty($data['getRecord']))
        {
           $data['header_title'] = "Editar Periodo ";
           return view('admin.periodo.edit', $data);
        }
        else
        {
            abort(404);
        }
        
    }

    public function update($id, Request $request)
    {
        $save = PeriodoModel::getSingle($id);
        $save->name = $request->name;
        $save->status = $request->status;
        $save->save();

        return redirect('admin/periodo/list')->with('success', "Actualizado Correctamente");
    }

    public function delete($id)
    {
       $save = PeriodoModel::getSingle($id);
       $save->is_delete = 1;
       $save->save();

       return redirect()->back()->with('success',"Periodo Academico Borrado");

    }


}
