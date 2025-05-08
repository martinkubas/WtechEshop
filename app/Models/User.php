<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 
        'full_name', 
        'email', 
        'password',
        'is_admin' 
    ];

    protected $hidden = ['password'];

    public function isAdmin()
    {
        return $this->is_admin === true;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
