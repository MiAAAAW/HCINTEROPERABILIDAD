<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredential extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'dni', 'ruc', 'password', 'last_updated_at'];

    // Relación con la tabla users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Encriptar automáticamente la contraseña al guardarla
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
