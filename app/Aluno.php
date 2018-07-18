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

    public function scopeSituacao($query, $search)
    {
        return $query->orWhereHas('registros', function ($query) use ($search) {
            $query->whereHas('situacoes', function($q) use ($search){
                $q->where('nome', 'LIKE', "%{$search}%");
            });
        });
    }

    public function scopeCurso($query, $search)
    {
        return $query->orWhere('id_curso', function ($q) use ($search){
            $q->select('id')->from('cursos')->where('nome', 'LIKE', "%{$search}%");
        });
    }

    public function scopeNome($query, $search)
    {
        return $query->where('nome', 'LIKE', "%{$search}%");
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
