<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $fillable = ['id', 'status', 'student_id', 'course_id'];

    protected $casts = [
        'id' => 'string'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function intentions()
    {
        return $this->belongsToMany(Subject::class, 'intentions')->withPivot('semestre', 'avaliado_cerel', 'avaliacao_coord', 'avaliado_coord')->withTimestamps();
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }
}