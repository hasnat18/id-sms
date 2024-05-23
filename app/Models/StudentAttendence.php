<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendence extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id', '__class_id', '__session_id', 'student_id', 'attendence', 'added_at' ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}
