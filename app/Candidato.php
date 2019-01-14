<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    public function status()
    {
        return $this->belongsTo(StatusMatricula::class, 'status_matricula_id');
    }

    public function cotaIngresso()
    {
        return $this->belongsTo(CotaMatricula::class, 'cota_ingresso');
    }

    public function cotaCandidato()
    {
        return $this->belongsTo(CotaMatricula::class, 'cota_candidato');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
    
    public function pendencias()
    {
        return $this->belongsToMany(DocumentoMatricula::class, 'pendencias');
    }

    public function servidor()
    {
        return $this->belongsTo(User::class);
    }
}
