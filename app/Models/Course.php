<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['nome'];

    public function students()
    {
        return $this->hasMany(Matricula::class);
    }
}
