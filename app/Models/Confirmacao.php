<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Confirmacao extends Model
{
    protected $fillable = ['cpf', 'nome', 'processo_seletivo_id'];
    
    public function edital()
    {
        return $this->belongsTo('App\Models\ProcessoSeletivo', 'processo_seletivo_id');
    }
}
