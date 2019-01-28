<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = ['nome', 'matricula', 'id_curso', 'registro_situacao_id', 'CR'];

    public function curso()
    {
        return $this->belongsTo('App\Models\Curso', 'id_curso');
    }

    public function registros()
    {
        return $this->hasMany('App\Models\Registro', 'id_alunos');
    }

    public function situacao()
    {
        return $this->belongsTo('App\Models\RegistroSituacao', 'registro_situacao_id');
    }

    public function disciplinas()
    {
        return $this->hasMany('App\Models\DisciplinaCurso', 'id_cursos', 'id_curso');
    }

    public function historico()
    {
        return $this->belongsToMany('App\Models\DisciplinaCurso', 'historico_escolares')->withPivot('status');
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
