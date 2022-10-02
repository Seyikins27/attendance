<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom','classroom_id');
    }

    public function venue()
    {
        return $this->belongsTo('App\Models\Venue','venue_id');
    }

    public function attendance_log()
    {
        return $this->hasMany('App\Models\AttendanceLog','attendance_id');
    }
}
