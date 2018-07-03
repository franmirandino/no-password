<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'login_token', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateLoginToken()
    {
        $this->update(['login_token' => str_random(60)]);
    }

    public function deleteTokenLogin()
    {
        $this->update(['login_token' => null]);
    }

    public function scopeByEmail($builder, $email)
    {

        return $builder->where('email', $email)->firstOrFail();

    }
}
