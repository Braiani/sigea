<?php

namespace App\Models;

use App\Models\Confirmacao;
use Illuminate\Database\Eloquent\Model;

class ProcessoSeletivo extends Model
{
    protected $guarded = [];

    public function confirmados(){
        return $this->hasMany(Confirmacao::class);
    }
}
