<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mensagem extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $table = 'mensagens';

    public function from()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function messageTo()
    {
        return $this->belongsTo('App\Models\User', 'to', 'id');
    }

    public function scopeMailFrom($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeMailTo($query, $id)
    {
        return $query->where('to', $id);
    }
}
