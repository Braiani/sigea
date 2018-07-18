<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    public function aluno()
    {
        return $this->belongsTo('App\Aluno', 'id_alunos');
    }

    public function disciplinas()
    {
        return $this->belongsTo('App\DisciplinaCurso', 'id_disciplina_cursos');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function situacoes()
    {
        return $this->hasOne('App\RegistroSituacao', 'id', 'situacao');
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
