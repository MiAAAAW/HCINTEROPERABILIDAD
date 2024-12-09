<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class InscribirModel extends Model
{
    use HasFactory;

    protected $table = "inscribir";

    protected $fillable = [
        'user_id',
        'periodo_cursos_id',
        'nota1',
        'nota2',
        'promedio',
        'aprobado'
    ];

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        $return = self::select('inscribir.*', 'users.codigo', 'users.name as estudiante_name', 'users.last_name as estudiante_last_name', 'cursos.cod', 'cursos.name as curso_name', 'cursos.cod', 'cursos.mension', 'periodo.name as periodo_name')
            ->join('users', 'users.id', '=', 'inscribir.user_id')
            ->join('periodo_cursos', 'periodo_cursos.id', '=', 'inscribir.periodo_cursos_id')
            ->join('cursos', 'cursos.id', '=', 'periodo_cursos.cursos_id')
            ->join('periodo', 'periodo.id', '=', 'periodo_cursos.periodo_id');

        if (!empty(Request::get('estudiante_name')))
        {
            $return = $return->where('users.name', 'like', '%' . Request::get('estudiante_name') . '%');
        }

        if (!empty(Request::get('estudiante_last_name')))
        {
            $return = $return->where('users.last_name', 'like', '%' . Request::get('estudiante_last_name') . '%');
        }

        if (!empty(Request::get('codigo')))
        {
            $return = $return->where('users.codigo', 'like', '%' . Request::get('codigo') . '%');
        }

        if(!empty(Request::get('cod')))
        {
           $return = $return->where('cursos.cod', '=', Request::get('cod'));
        }

        if (!empty(Request::get('curso_name')))
        {
            $return = $return->where('cursos.name', 'like', '%' . Request::get('curso_name') . '%');
        }

        if (!empty(Request::get('periodo_name')))
        {
            $return = $return->where('periodo.name', 'like', '%' . Request::get('periodo_name') . '%');
        }

        if (!empty(Request::get('mension')))
        {
            $return = $return->where('cursos.mension', 'like', '%' . Request::get('mension') . '%');
        }

        $return = $return->orderBy('inscribir.id', 'desc')
            ->paginate(40);

        return $return;
    }

    public function setNota1Attribute($value)
    {
        $this->attributes['nota1'] = $value;
        $this->calculatePromedio();
    }

    public function setNota2Attribute($value)
    {
        $this->attributes['nota2'] = $value;
        $this->calculatePromedio();
    }

    protected function calculatePromedio()
    {
        $nota1 = $this->attributes['nota1'] ?? null;
        $nota2 = $this->attributes['nota2'] ?? null;

        $notas = array_filter([$nota1, $nota2], function($nota) {
            return !is_null($nota);
        });

        if (count($notas) >= 2) {
            $this->attributes['promedio'] = array_sum($notas) / count($notas);
            $this->attributes['aprobado'] = $this->attributes['promedio'] > 13 ? 'Aprobado' : 'Desaprobado';
        } else {
            $this->attributes['promedio'] = null;
            $this->attributes['aprobado'] = 'En proceso';
        }
    }

    public function periodoCurso()
    {
        return $this->belongsTo(PrdCursosModel::class, 'periodo_cursos_id');
    }
}