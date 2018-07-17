<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    public function curso()
    {
        return $this->belongsTo('App\Curso', 'id_curso');
    }

    public function registros()
    {
        return $this->hasMany('App\Registro', 'id_alunos');
    }

    public function getCRFormatadoAttribute()
    {
        return sprintf("%1.4f", $this->CR);
    }

    public function getNomeFormatadoAttribute()
    {
        return ucwords(mb_strtolower($this->nome, 'UTF-8'));
    }
}
