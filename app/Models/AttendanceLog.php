<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function attendance()
    {
        return $this->belongsTo('App\Models\Attendance','attendance_id');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student','student_id');
    }
}
