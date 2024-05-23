<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;

    protected $fillable = [
        '__class_id',
        'subject_id',
        'start_time',
        'end_time',
        'day',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
