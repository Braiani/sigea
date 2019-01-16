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
        return $this->hasRole('admin');
    }

    public function getisCogeaAttribute()
    {
        return $this->hasRole('cogea');
    }

    public function getisCoordAttribute()
    {
        return $this->hasRole('coords');
    }
    
    public function getisNugedAttribute()
    {
        return $this->hasRole('nuged');
    }
}
