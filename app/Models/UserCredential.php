<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class UserCredential extends Model
{
    use HasFactory;

    /**
     * Atributos asignables en masa.
     */
    protected $fillable = ['user_id', 'dni', 'ruc', 'password', 'last_updated_at'];

    /**
     * Relación con el modelo de usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verificar si la contraseña ha caducado.
     *
     * @return bool
     */
    public function isPasswordExpired()
    {
        return $this->last_updated_at ? now()->diffInDays($this->last_updated_at) >= 14 : true;
    }

    /**
     * Mutador para cifrar la contraseña automáticamente.
     *
     * @param string $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Accesor para formatear la fecha de última actualización.
     *
     * @return string
     */
    public function getLastUpdatedAtFormattedAttribute()
    {
        return $this->last_updated_at ? Carbon::parse($this->last_updated_at)->format('d/m/Y H:i:s') : 'No disponible';
    }
}
