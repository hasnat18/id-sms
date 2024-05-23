<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    protected $fillable = [
        'name',
        'gender',
        'dob',
        'address',
        'phone',
        'email',
        'joining_date',
        'salary',
        'extra_note',
        'is_bus_incharge',
        'transport_id',
        'user_id',
        'added_by',
        'id_proof',
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class, 'transport_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_staff');
    }

    public function staff_atd()
    {
        return $this->hasOne(StaffAttendence::class, 'staff_id');
    }

    public function staff_atds()
    {
        return $this->hasMany(StaffAttendence::class, 'staff_id');
    }

    public function salary()
    {
        return $this->hasOne(Salary::class, 'staff_id');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'staff_id');
    }

    public function leave()
    {
        return $this->hasOne(StaffLeave::class, 'staff_id');
    }

    public function leaves()
    {
        return $this->hasMany(StaffLeave::class, 'staff_id');
    }
}
