<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
//use Illuminate\Http\Client\Request;
//use Illuminate\Http\Request;
//use Symfony\Component\HttpFoundation\Request;
//use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'dni',
        'email',
        'codigo',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getAdmin()
    {
        $return = self::select('users.*')
                         ->where('user_type','=',1)
                         ->where('is_delete','=',0);
                         
        if (!empty(Request::get('name'))) {
            $return = $return->where('name','like', '%' . Request::get('name') .'%');
        }

        if (!empty(Request::get('email'))) {
            $return = $return->where('email','like', '%' . Request::get('email') .'%');
        }

        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('created_at','=', Request::get('date'));
        }

        $return = $return->orderBy('id','desc')
                         ->paginate(10);  

        return $return;                
    }

    static public function getEstudiante()
    {
        $return = self::select('users.*')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0);
                         
        if (!empty(Request::get('name'))) {
            $return = $return->where('users.name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('last_name'))) {
            $return = $return->where('users.last_name', 'like', '%' . Request::get('last_name') . '%');
        }

        if (!empty(Request::get('dni'))) {
            $return = $return->where('users.dni', 'like', '%' . Request::get('dni') . '%');
        }

        if (!empty(Request::get('email'))) {
            $return = $return->where('users.email', 'like', '%' . Request::get('email') . '%');
        }

        if (!empty(Request::get('codigo'))) {
            $return = $return->where('users.codigo', 'like', '%' . Request::get('codigo') . '%');
        }

        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('users.created_at', '=', Request::get('date'));
        }

        $return = $return->orderBy('users.id', 'desc')
            ->paginate(39);

        return $return;
    }
    
    static public function getEmailSingle($email)
    {
        return User::where('email', '=',$email)->first();
    }

    static public function getTokenSingle($remember_token)
    {
        return User::where('remember_token', '=', $remember_token)->first();
    }
}