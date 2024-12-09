<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class PeriodoModel extends Model
{
    use HasFactory;

    protected $table = "periodo";

    static public function getSingle($id)
    {
       return self::find($id); 
    }

    static public function getRecord()
    {
        $return = PeriodoModel::select('periodo.*' , "users.name as created_by_name")
                      ->join('users' , 'users.id', 'periodo.created_by');

                      if(!empty(Request::get('name')))
                      {
                        $return = $return->where('periodo.name', 'like', '%' .Request::get('name'). '%');
                      }

                      if(!empty(Request::get('date')))
                      {
                        $return = $return->whereDate('periodo.created_at','=', Request::get('date'));
                      }

                      $return = $return->where('periodo.is_delete', '=', 0)
                      ->orderBy('periodo.id', 'desc')
                      ->paginate(20);

        return $return;              

    }

    static public function getPeriodo()
    {
        $return = PeriodoModel::select('periodo.*')
                      ->join('users' , 'users.id', 'periodo.created_by')
                      ->where('periodo.is_delete', '=', 0)
                      ->where('periodo.status', '=', 0)
                      ->orderBy('periodo.name', 'asc')
                      ->get();

        return $return;              

    }


    
}
