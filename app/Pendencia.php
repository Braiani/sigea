<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendencia extends Model
{
    protected $fillable = ['documento_matricula_id', 'candidato_id', 'user_id'];
    
    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    public function documento()
    {
        return $this->belongsTo(DocumentoMatricula::class, 'documento_matricula_id');
    }
}
