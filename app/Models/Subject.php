<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [ '__class_id', 'name' ];

    public function _class()
    {
        return $this->belongsTo(_Class::class, '__class_id');
    }

    public function staffs()
    {
        return $this->belongsToMany(Staff::class, 'subject_staff');
    }

    public function timetable()
    {
        return $this->hasOne(TimeTable::class, 'subject_id');
    }
}
