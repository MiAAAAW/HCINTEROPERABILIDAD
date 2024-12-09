<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class PrdCursosModel extends Model
{
    use HasFactory;

    protected $table = "periodo_cursos";

    static public function getSingle($id)
    { 
        return self::find($id);
    }

    static public function getRecord()
    { 
        $return = self::select('periodo_cursos.*', 'periodo.name as periodo_name', 'cursos.name as cursos_name', 'cursos.cod', 'cursos.mension', 'users.name as created_by_name')
                    ->join('cursos', 'cursos.id', '=', 'periodo_cursos.cursos_id')
                    ->join('periodo', 'periodo.id', '=', 'periodo_cursos.periodo_id')
                    ->join('users', 'users.id', '=', 'periodo_cursos.created_by')
                    ->where('cursos.status', '=', 0)
                    ->where('periodo_cursos.is_delete', '=' , 0 );

                    if(!empty(Request::get('periodo_name')))
                      {
                        $return = $return->where('periodo.name', 'like', '%' .Request::get('periodo_name'). '%');
                      }

                    if(!empty(Request::get('cursos_name')))
                      {
                        $return = $return->where('cursos.name', 'like', '%' .Request::get('cursos_name'). '%');
                      } 

                    if(!empty(Request::get('cod')))
                      {
                        $return = $return->where('cursos.cod', '=', Request::get('cod'));
                      }

                    if(!empty(Request::get('mension')))
                      {
                        $return = $return->where('cursos.mension', 'like', '%' .Request::get('mension'). '%');
                      }

                    if(!empty(Request::get('date')))
                      {
                        $return = $return->whereDate('periodo_cursos.created_at','=', Request::get('date'));
                      }

        $return = $return->orderBy('periodo_cursos.id', 'desc')
                    ->paginate(10);
        
        return $return;            
    }

    static public function getAlreadyFirst($periodo_id, $cursos_id)
    { 
        return self::where('periodo_id','=', $periodo_id)
                    ->where('cursos_id','=', $cursos_id )
                    ->first();
    }

    static public function getPrdCursosID($periodo_id)
    { 
        return self::where('periodo_id','=', $periodo_id)->where('is_delete','=', 0)->get();
    }

    static public function deleteCursos($periodo_id) 
    { 
        return self::where('periodo_id','=', $periodo_id)->delete();
    }

    public function curso()
    {
        return $this->belongsTo(CursosModel::class, 'cursos_id');
    }

    public function periodo()
    {
        return $this->belongsTo(PeriodoModel::class, 'periodo_id');
    }
}