<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoMatricula extends Model
{
    public function cotas()
    {
        return $this->belongsToMany(CotaMatricula::class, 'cota_documento');
    }
    
    public function pendencias()
    {
        return $this->belongsToMany(Candidato::class, 'pendencias');
    }
}
