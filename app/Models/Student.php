<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        '__class_id',
        '__session_id',
        'roll_no',
        'name',
        'status',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function fees()
    {
        return $this->hasOne(Fees::class);
    }

    public function _class()
    {
        return $this->belongsTo(_Class::class, '__class_id');
    }

    public function leave()
    {
        return $this->hasOne(StudentLeave::class, 'student_id');
    }

    public function _session()
    {
        return $this->belongsTo(_Session::class,'__session_id');
    }

}
