<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredential extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'dni', 'ruc', 'password', 'last_updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPasswordExpired()
    {
        return now()->diffInDays($this->last_updated_at) >= 15;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
