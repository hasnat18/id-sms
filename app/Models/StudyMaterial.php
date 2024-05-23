<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
            'class_id',
            'user_id',
            'upload',
            'text',
    ];

    public function __class()
    {
        return $this->belongsTo(_Class::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
