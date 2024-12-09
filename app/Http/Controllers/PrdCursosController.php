<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PrdCursosModel;
use App\Models\CursosModel;
use App\Models\PeriodoModel;

class PrdCursosController extends Controller
{
    public function list(Request $request) 
    {
        $data['getRecord'] = PrdCursosModel::getRecord();

        $data['header_title'] = "Periodo-Cursos";
        return view('admin.periodo_cursos.list', $data);

    } 

    public function add(Request $request) 
    {
        $data['getPeriodo'] = PeriodoModel::getPeriodo();
        $data['getCursos'] = CursosModel::getCursos();
        $data['header_title'] = "Asignar Periodo-Cursos";
        return view('admin.periodo_cursos.add', $data);

    } 

    public function insert(Request $request) 
    {
        if(!empty($request->cursos_id))
        {
            foreach($request->cursos_id as $cursos_id)
            {
              $getAlreadyFirst = PrdCursosModel::getAlreadyFirst($request->periodo_id, $cursos_id);
              if(!empty($getAlreadyFirst))
              {
                $getAlreadyFirst->status = $request->status;
                $getAlreadyFirst->save();
              }
              else  
              {
                $save = new PrdCursosModel;
                $save->periodo_id = $request->periodo_id;
                $save->cursos_id = $cursos_id;
                $save->status = $request->status;
                $save->created_by = Auth::user()->id;
                $save->save();
              } 
            }
        return redirect('admin/periodo_cursos/list')->with('success',"Curso correctamente asignado");
        }
        else
        {
            return redirect()->back()->with('error','Se encontro errores,Intente de Nuevo ');
        }
    } 

    public function edit($id) 
    {
        $getRecord = PrdCursosModel::getSingle($id);
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getPrdCursosID'] = PrdCursosModel::getPrdCursosID($getRecord->periodo_id);
            $data['getPeriodo'] = PeriodoModel::getPeriodo();
            $data['getCursos'] = CursosModel::getCursos();
            $data['header_title'] = "Editar Periodo-Cursos";
            return view('admin.periodo_cursos.edit', $data);
        }
        else
        {
            abort(404);
        }
    } 

    public function update(Request $request) 
    {
       
        PrdCursosModel::deleteCursos($request->periodo_id);

        if(!empty($request->cursos_id))
        {
           foreach($request->cursos_id as $cursos_id){

              $getAlreadyFirst = PrdCursosModel::getAlreadyFirst($request->periodo_id, $cursos_id);
              if(!empty($getAlreadyFirst))
              {
                $getAlreadyFirst->status = $request->status;
                $getAlreadyFirst->save();
              }
              else
              {
                $save = new PrdCursosModel;
                $save->periodo_id = $request->periodo_id;
                $save->cursos_id = $cursos_id;
                $save->status = $request->status;
                $save->created_by = Auth::user()->id;
                $save->save();
              }
           } 
        }
        return redirect('admin/periodo_cursos/list')->with('success',"Curso correctamente asignado");
        
    } 

    public function delete($id) 
    {
        $save = PrdCursosModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success','Registro Borrado Correctamente');

    } 

    public function edit_single($id) 
    {
        $getRecord = PrdCursosModel::getSingle($id);
        if(!empty($getRecord))
        {
            $data['getRecord'] = $getRecord;
            $data['getPeriodo'] = PeriodoModel::getPeriodo();
            $data['getCursos'] = CursosModel::getCursos();
            $data['header_title'] = "Editar Periodo-Cursos";
            return view('admin.periodo_cursos.edit_single', $data);
        }
        else
        {
            abort(404);
        }

    }

    public function update_single($id,Request $request) 
    {
    
        $getAlreadyFirst = PrdCursosModel::getAlreadyFirst($request->periodo_id, $request->cursos_id);
        if(!empty($getAlreadyFirst))
        {
           $getAlreadyFirst->status = $request->status;
           $getAlreadyFirst->save();

           return redirect('admin/periodo_cursos/list')->with('success',"Curso correctamente actualizado");
        }
        else
        {
            $save = PrdCursosModel::getSingle($id);
            $save->periodo_id = $request->periodo_id;
            $save->cursos_id = $request->cursos_id; 
            $save->status = $request->status;
            $save->save();

            return redirect('admin/periodo_cursos/list')->with('success',"Curso correctamente asignado");
        } 
    }



}
