<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    public function curso()
    {
        return $this->belongsTo('App\Curso', 'id_curso');
    }

    public function getNomeFormatadoAttribute()
    {
        return ucwords(mb_strtolower($this->nome, 'UTF-8'));
    }
}
