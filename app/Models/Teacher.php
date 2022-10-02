<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $hidden = [
        'password'
    ];

    public function _fullname()
    {
        return ucfirst($this->title)." ".ucfirst($this->fullname);
    }

    public function classroom()
    {
        return $this->hasMany('App\Models\Classroom','teacher_id');
    }
}
