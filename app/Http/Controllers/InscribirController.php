<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InscribirModel;
use App\Models\User;
use App\Models\PrdCursosModel;

class InscribirController extends Controller
{
    public function list(Request $request)
    {
        $data['getRecord'] = InscribirModel::getRecord();
        $data['header_title'] = "Lista de Inscripciones";

        // Calcular los totales
        $data['total_en_proceso'] = InscribirModel::where('aprobado', 'En proceso')->count();
        $data['total_aprobados'] = InscribirModel::where('aprobado', 'Aprobado')->count();
        $data['total_desaprobados'] = InscribirModel::where('aprobado', 'Desaprobado')->count();
        return view('admin.inscribir.list', $data);
    }

    public function searchStudents(Request $request)
    {
        $term = $request->input('q');

        $students = User::where('user_type', 3)
                        ->where('is_delete', 0)
                        ->where(function($query) use ($term) {
                            $query->where('name', 'LIKE', '%' . $term . '%')
                                  ->orWhere('last_name', 'LIKE', '%' . $term . '%')
                                  ->orWhere('dni', 'LIKE', '%' . $term . '%')
                                  ->orWhere('codigo', 'LIKE', '%' . $term . '%');
                        })
                        ->get();

        return response()->json($students);
    }

    public function add(Request $request)
    {
        $data['getEstudiantes'] = User::where('user_type', 3)->where('is_delete', 0)->get(); // Obtener todos los estudiantes
        $data['getPeriodoCursos'] = PrdCursosModel::with('curso', 'periodo')
            ->whereHas('curso', function($query) {
                $query->where('status', 0); // Filtrar solo los cursos activos
            })
            ->where('status', 0) // Filtrar solo los periodos_cursos activos
            ->get();
        $data['header_title'] = "Inscribir Estudiante a Curso";
        return view('admin.inscribir.add', $data);
    }

    public function insert(Request $request)
    {
        request()->validate([
            'user_id' => 'required|exists:users,id',
            'periodo_cursos_ids' => 'required|array',
            'periodo_cursos_ids.*' => 'exists:periodo_cursos,id',
        ]);
    
        foreach ($request->periodo_cursos_ids as $curso_id) {
            $inscribir = new InscribirModel;
            $inscribir->user_id = $request->user_id;
            $inscribir->periodo_cursos_id = $curso_id;
            $inscribir->save();
        }
    
        return redirect('admin/inscribir/list')->with('success', "Estudiante inscrito correctamente en los cursos seleccionados");
    }

    public function edit($id)
    {
        $getRecord = InscribirModel::getSingle($id);
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['header_title'] = "Editar Notas del Estudiante";
            return view('admin.inscribir.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'nota1' => 'nullable|numeric|min:0|max:20',
            'nota2' => 'nullable|numeric|min:0|max:20',
        ]);
    
        $inscribir = InscribirModel::getSingle($id);
        if (!empty($inscribir)) {
            $inscribir->nota1 = $request->nota1;
            $inscribir->nota2 = $request->nota2;
            $inscribir->save();
    
            // Redirigir a la lista con los parámetros de búsqueda
            return redirect()->to('admin/inscribir/list?' . http_build_query(request()->query()))->with('success', "Notas actualizadas correctamente");
        } else {
            return redirect('admin/inscribir/list')->with('error', "Inscripción no encontrada");
        }
    }

    public function delete($id)
    {
        $inscribir = InscribirModel::getSingle($id);
        if (!empty($inscribir)) {
            $inscribir->delete();
            return redirect()->back()->with('success', "Inscripción borrada correctamente");
        } else {
            return redirect()->back()->with('error', "Inscripción no encontrada");
        }
    }
}