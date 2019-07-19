<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intention extends Model
{
    use SoftDeletes;

    protected $fillable = ['matricula_id', 'subject_id', 'semestre', 'avaliado_cerel', 'avaliacao_coord', 'avaliado_coord'];
}
