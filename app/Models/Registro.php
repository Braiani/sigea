<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    public function aluno()
    {
        return $this->belongsTo('App\Models\Aluno', 'id_alunos');
    }

    public function disciplinas()
    {
        return $this->belongsTo('App\Models\DisciplinaCurso', 'id_disciplina_cursos');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function situacoes()
    {
        return $this->hasOne('App\Models\RegistroSituacao', 'id', 'situacao');
    }

    public function scopeAlunoRegistrado($query, $id)
    {
        return $query->where('id_alunos', $id);
    }

    public function scopeDisciplinaRegistrada($query, $id)
    {
        return $query->where('id_disciplina_cursos', $id);
    }
}
