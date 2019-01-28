<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoEscolar extends Model
{
    protected $table = 'historico_escolares';

    protected $fillable = ['aluno_id', 'disciplina_curso_id', 'status'];
}
