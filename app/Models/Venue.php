<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function attendance()
    {
        return $this->hasMany('App\Models\Attendance', 'classroom_id');
    }
}
