<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessoSeletivo extends Model
{
    protected $guarded = [];

    public function confirmados(){
        return $this->hasMany(Confirmacao::class);
    }
}
