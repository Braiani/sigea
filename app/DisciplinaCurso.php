<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisciplinaCurso extends Model
{
    public function curso()
    {
        return $this->belongsTo('App\Curso', 'id_curso');
    }

    public function scopeCursoDisciplina($query, $id)
    {
        return $query->where('id_cursos', $id);
    }

    public function scopeSemestre($query, $id)
    {
        return $query->where('semestre', $id);
    }
}
