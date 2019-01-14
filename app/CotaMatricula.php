<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotaMatricula extends Model
{
    public function documentos()
    {
        return $this->belongsToMany(DocumentoMatricula::class, 'cota_documento');
    }
}
