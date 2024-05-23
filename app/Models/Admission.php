<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'gr_no',
        'student_name',
        'student_email',
        'student_gender',
        'student_phone',
        'student_dob',
        'student_address',
        'student_nationality',
        'student_religion',
        'student_last_school_attend',
        'student_admission_date',
        'student_state',
        'student_city',
        'student_country',
        'student_pic',
        'father_name',
        'father_occupation',
        'father_office_address',
        'father_contact',
        'guardian_name',
        'guardian_occupation',
        'guardian_office_address',
        'guardian_contact',
        'mother_name',
        'mother_contact',
        'transport_id',
        '__class_id',
        '__session_id',
        'user_id',
        'student_auth_id',
        'status',
        'extra_note',
    ];

    public function _class()
    {
        return $this->belongsTo(_Class::class, '__class_id');
    }

    public function transfer()
    {
        return $this->hasOne(Transfer::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function fees()
    {
        return $this->hasMany(Fees::class, 'admission_id');
    }

    public function studentAtd()
    {
        return $this->hasMany(StudentAttendence::class);
    }

    public function result()
    {
        return $this->hasMany(Result::class, 'admission_id');
    }

    public function st()
    {
        return $this->belongsTo(Transport::class, 'transport_id');
    }
}