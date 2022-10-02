<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomStudent extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom','classroom_id');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student','student_id');
    }
}
