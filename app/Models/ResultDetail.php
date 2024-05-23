<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultDetail extends Model
{
    use HasFactory;

    protected $fillable = [
            'result_id',
            'subject_name',
            'subject_marks',
            'obtained_marks',
    ];
}
