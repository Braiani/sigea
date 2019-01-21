<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusMatricula extends Model
{
    public function candidatos()
    {
        return $this->hasMany(Candidato::class);
    }
    
    public function scopeEmAnalise($query)
    {
        return $query->where('padrao_analise', true);
    }
    
    public function scopeMatriculado($query)
    {
        return $query->where('padrao_matriculado', true);
    }
    
    public function scopeReclassificado($query)
    {
        return $query->where('padrao_reclassificacao', true);
    }
    
    public function scopeDeferido($query)
    {
        return $query->where('descricao', 'Deferido');
    }
    
    public function scopeIndeferido($query)
    {
        return $query->where('descricao', 'Indeferido');
    }
}
