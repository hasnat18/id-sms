<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        'school_name',
        'class_name',
        'doc',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}
