<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name', 'gender', 'dob', 'religion',
        'cast', 'blood_group', 'address', 'city', 'state', 'country',
        'phone', 'email', 'id_no', 'id_proof', 'extra_note', 'father_name',
        'father_phone','father_occ','mother_name','mother_phone','mother_occ','class_name',
        'status'
    ];
}
