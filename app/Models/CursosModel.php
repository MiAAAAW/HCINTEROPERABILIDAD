<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class CursosModel extends Model
{
    use HasFactory;
    protected $table = "cursos";

    protected $fillable = ['cod', 'name', 'mension', 'type', 'status', 'created_by', 'is_delete', 'created_at', 'updated_at'];

    static public function getSingle($id)
    {
       return self::find($id);
    }   

    static public function getRecord()
    {
        $return = CursosModel::select('cursos.*' , "users.name as created_by_name", 'cursos.cod', 'cursos.mension')
                      ->join('users' , 'users.id', 'cursos.created_by')
                      ->where('cursos.is_delete', '=', 0);

                      if(!empty(Request::get('name')))
                      {
                        $return = $return->where('cursos.name', 'like', '%' .Request::get('name'). '%');
                      }

                      if(!empty(Request::get('cod')))
                      {
                        $return = $return->where('cursos.cod', '=', Request::get('cod'));
                      }

                      if(!empty(Request::get('mension')))
                      {
                        $return = $return->where('cursos.mension', 'like', '%' .Request::get('mension'). '%');
                      }

                      if(!empty(Request::get('type')))
                      {
                        $return = $return->where('cursos.type', '=', Request::get('type'));
                      }

                      if(!empty(Request::get('date')))
                      {
                        $return = $return->whereDate('cursos.created_at','=', Request::get('date'));
                      }

                     $return = $return->orderBy('cursos.id', 'desc')
                     ->paginate(30);

          return $return;
    }

    static public function getCursos()
    {
        $return = CursosModel::select('cursos.*', 'cursos.cod', 'cursos.mension')
                      ->join('users' , 'users.id', 'cursos.created_by')
                      ->where('cursos.is_delete', '=', 0)
                      ->where('cursos.status', '=', 0)
                      ->orderBy('cursos.name', 'asc')
                      ->get();

        return $return;  
    }
}