<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        '__session_id',
        'student_id',
        '__class_id',
        'user_id',
        'month_of',
        'due_date',
        'paid_at',
        'issued_at',
        'arrears',
        'total',
        'status',
    ];

    public function _session()
    {
        return $this->belongsTo(_Session::class, '__session_id');
    }

    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function _class()
    {
        return $this->belongsTo(_Class::class, 'class_id');
    }
    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    public function feedetails()
    {
        return $this->hasMany(FeeDetails::class, 'fee_id');
    }
}
