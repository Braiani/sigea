<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroSituacao extends Model
{
    protected $table = 'registro_situacao';

    public function scopeDependencia($query)
    {
        return $query->where('nome', 'Dependência');
    }

    public function scopeRetido($query)
    {
        return $query->where('nome', 'Retido');
    }

    public function scopeRegular($query)
    {
        return $query->where('nome', 'Regular');
    }
}
