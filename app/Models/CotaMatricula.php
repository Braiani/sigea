<?php

namespace App\Models;

use App\Models\DocumentoMatricula;
use Illuminate\Database\Eloquent\Model;

class CotaMatricula extends Model
{
    public function documentos()
    {
        return $this->belongsToMany(DocumentoMatricula::class, 'cota_documento');
    }
}
