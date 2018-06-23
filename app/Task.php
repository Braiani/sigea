<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at', 'deadline'];
    protected $guarded = [];

    public function userTo()
    {
        return $this->belongsTo('App\User', 'user_to');
    }

    public function scopeToUser($query, $id)
    {
        return $query->where('user_to', $id);
    }
}
