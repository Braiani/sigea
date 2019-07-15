<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Foundation\Auth\User as Authenticable;

class Student extends Authenticable
{
    protected $fillable = ['name', 'cpf', 'email', 'born', 'api_token'];

    protected $dates = ['born'];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
