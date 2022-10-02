<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function attendance()
    {
        return $this->hasMany('App\Models\Attendance', 'classroom_id');
    }

   public function classroom_student()
    {
        return $this->hasMany('App\Models\ClassroomStudent','classroom_id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher','teacher_id');
    }


}
