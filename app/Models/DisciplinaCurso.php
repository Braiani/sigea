<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinaCurso extends Model
{
    public function curso()
    {
        return $this->belongsTo('App\Models\Curso', 'id_curso');
    }

    public function scopeCursoDisciplina($query, $id)
    {
        return $query->where('id_cursos', $id);
    }

    public function scopeSemestre($query, $id)
    {
        return $query->where('semestre', $id);
    }

    public function getNomeFormatadoAttribute()
    {
        return ucfirst(mb_strtolower(str_replace('*', '', $this->nome), 'UTF-8'));
    }
}
