<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'cpf', 'email', 'born'];

    protected $dates = ['born'];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
