<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'about',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getisAdminAttribute()
    {
        return $this->role->name == 'admin' ;
    }

    public function getisCogeaAttribute()
    {
        return $this->role->name == 'cogea' ;
    }

    public function getisCoordAttribute()
    {
        return $this->role->name == 'coords' ;
    }
}
