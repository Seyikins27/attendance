<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function _fullname()
    {
        return ucfirst($this->lastname)." ".ucfirst($this->firstname)." ".ucfirst($this->middlename);
    }

    public function classroom_student()
    {
        return $this->hasMany('App\Models\ClassroomStudent','student_id');
    }

    public function attendance_log()
    {
        return $this->hasMany('App\Models\AttendanceLog','student_id');
    }
}
